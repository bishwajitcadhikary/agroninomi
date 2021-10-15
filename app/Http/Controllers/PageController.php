<?php

namespace App\Http\Controllers;

use App\DataTables\PagesDataTable;
use App\Http\Requests\Pages\StorePageRequest;
use App\Models\Page;
use App\Services\Facebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:page_create')->only('create', 'store');
        $this->middleware('permission:page_read')->only('index');
        $this->middleware('permission:page_update')->only('edit', 'update');
        $this->middleware('permission:page_delete')->only('destroy');
    }

    public function index(PagesDataTable $dataTable)
    {
        return $dataTable->render('pages.index');
    }

    public function create()
    {
        return view('pages.create');
    }

    public function search(Request $request)
    {
        $facebook = new Facebook();
        $name = $request->get('name');
        $location = $request->get('location');
        $fields = $request->get('fields');

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
            return view('pages.list', [
                'pages' => $pages
            ]);
        }else{
            return response()->json(['message' => 'Pages not found'], 404);
        }
    }

    public function store(StorePageRequest $request)
    {
        foreach ($request->input('page_id') as $pageId) {
            Page::updateOrCreate([
                'page_id' => $pageId,
                'user_id' => auth()->id()
            ]);
        }

        return response()->json('Pages Added Successfully');
    }

    public function destroy(Page $page)
    {
        $page->delete();

        return response()->json('Page Deleted Successfully');
    }
}
