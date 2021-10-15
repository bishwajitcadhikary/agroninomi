<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\PageRequest;
use App\Http\Requests\Api\V1\PagesSearchRequest;
use App\Models\Page;
use App\Services\Facebook;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PageController extends Controller
{
    public function index()
    {
        return Page::whereUserId(auth()->id())->get();
    }

    public function store(PageRequest $request)
    {
        try {
            foreach ($request->input('pages_id') as $pageId) {
                Page::updateOrCreate([
                    'page_id' => $pageId,
                    'user_id' => auth()->id()
                ]);
            }

            return response()->json('Pages Added Successfully');
        }catch (\Throwable $exception){
            return response()->json($exception->getMessage(), 422);
        }
    }

    public function show(Page $page)
    {
        return response()->json($page);
    }

    public function destroy(Page $page)
    {
        $page->delete();

        return response()->json('Page Deleted Successfully');
    }

    public function search(PagesSearchRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $facebook = new Facebook();
            $name = $validatedData['name'];
            $location = $validatedData['location'];
            $fields = 'id,name,link,location';

            $searchPages = $facebook->searchPages($name, $fields);

            if (isset($searchPages->error)){
                return response()->json(['message' => 'Pages search is not allowed in this app'], 403);
            }

            $pages = [];
            foreach ($searchPages->data as $data){
                foreach ($data->location as $value){
                    if ($location === ""){
                        $pages[] = $data;
                    }else{
                        $strpos = strpos($value, $location);
                        $str_contains = str_contains($value, $location);

                        if ($value == $location || $strpos === true || $str_contains) {
                            $pages[] = $data;
                        }
                    }
                }
            }

            if (count($pages) > 0){
                return response()->json(['data' => $pages]);
            }else{
                return response()->json(['message' => 'Pages not found'], 404);
            }
        }catch (\Throwable $exception){
            return response()->json($exception->getMessage(), 422);
        }
    }
}
