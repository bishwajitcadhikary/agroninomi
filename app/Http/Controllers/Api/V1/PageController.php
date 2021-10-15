<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
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

    public function store(Request $request)
    {
        try {
            $request->validate([
                'pages_id' => ['required', 'array']
            ]);

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

    public function search(Request $request)
    {
        $facebook = new Facebook();
        $name = $request->get('name');
        $location = $request->get('location');
        $fields = $request->get('fields');

        //Demo Purpose
        $demoResponse = Http::withHeaders([
            'X-API-Key' => "fd638ca0"
        ])->get("https://my.api.mockaroo.com/facebook_pages_search.json");

        $decode = json_decode($demoResponse);

        $demoData = ['data' => $decode];
        $demoData = json_encode($demoData);
        $demoData = json_decode($demoData);

        $pages = [];
        foreach ($demoData->data as $data){
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
        // End Demo

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
    }
}
