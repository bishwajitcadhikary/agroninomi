<?php

namespace App\Http\Controllers;

use App\DataTables\AppsDataTable;
use App\Http\Requests\Apps\StoreAppRequest;
use App\Http\Requests\Apps\UpdateAppRequest;
use App\Models\App;
use App\Services\Facebook;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:app_create')->only('create', 'store');
        $this->middleware('permission:app_read')->only('index');
        $this->middleware('permission:app_update')->only('edit', 'update');
        $this->middleware('permission:app_delete')->only('destroy');
    }

    public function index(AppsDataTable $dataTable)
    {
        return $dataTable->render('apps.index');
    }

    public function create(Request $request)
    {
        return view('apps.create');
    }

    public function store(StoreAppRequest $request)
    {
        $facebook = new Facebook();
        $clientId = $request->input('client_id');
        $clientSecret = $request->input('client_secret');
        $oauthAccessToken = $facebook->oauthAccessToken($clientId, $clientSecret);

        if (isset($oauthAccessToken->error)){
            return response()->json(['message' => $oauthAccessToken->error->message], 404);
        }

        $appInfo = $facebook->appInfo($clientId, $oauthAccessToken->access_token);

        if (isset($appInfo->error)){
            return response()->json(['message' => $appInfo->error->message], 404);
        }

        App::updateOrCreate([
            'client_id' => $clientId
        ], [
            'name' => $appInfo->name,
            'client_secret' => $clientSecret,
            'access_token' => $oauthAccessToken->access_token,
            'photo_url' => $appInfo->photo_url,
            'user_id' => auth()->id()
        ]);

        return response()->json('App Added Successfully', 201);
    }

    public function edit(App $app)
    {
        return view('apps.edit', [
            'app' => $app
        ]);
    }

    public function update(UpdateAppRequest $request, App $app)
    {
        $facebook = new Facebook();
        $clientId = $request->input('client_id');
        $clientSecret = $request->input('client_secret');
        $oauthAccessToken = $facebook->oauthAccessToken($clientId, $clientSecret);

        if (isset($oauthAccessToken->error)){
            return response()->json(['message' => $oauthAccessToken->error->message], 404);
        }

        $appInfo = $facebook->appInfo($clientId, $oauthAccessToken->access_token);

        if (isset($appInfo->error)){
            return response()->json(['message' => $appInfo->error->message], 404);
        }

        $app->update([
            'name' => $appInfo->name,
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'access_token' => $oauthAccessToken->access_token,
            'photo_url' => $appInfo->photo_url,
            'user_id' => auth()->id()
        ]);

        return response()->json('App Update Successfully');
    }

    public function destroy(App $app)
    {
        $app->delete();

        return response()->json('App Update Successfully');
    }
}
