<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\App;
use App\Services\Facebook;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class AppController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:app_read')->only('index', 'show');
        $this->middleware('permission:app_create')->only('store');
        $this->middleware('permission:app_update')->only('update');
    }

    public function index()
    {
        return App::all();
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'client_id' => ['required', 'numeric'],
                'client_secret' => ['required', 'string']
            ]);

            $facebook = new Facebook();
            $clientId = $request->input('client_id');
            $clientSecret = $request->input('client_secret');
            $oauthAccessToken = $facebook->oauthAccessToken($clientId, $clientSecret);

            if (isset($oauthAccessToken->error)) {
                return response()->json(['message' => $oauthAccessToken->error->message], 404);
            }

            $appInfo = $facebook->appInfo($clientId, $oauthAccessToken->access_token);

            if (isset($appInfo->error)) {
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
        } catch (Throwable $exception) {
            return response()->json($exception->getMessage(), 422);
        }
    }

    public function update(Request $request, App $app)
    {
        try {
            $request->validate([
                'client_id' => ['required', 'numeric'],
                'client_secret' => ['required', 'string']
            ]);

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
        }catch (Throwable $exception){
            return response()->json($exception->getMessage(), 422);
        }
    }

    public function destroy(App $app)
    {
        $app->delete();

        return \response()->json('App Deleted Successfully');
    }
}
