<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\AppRequest;
use App\Models\App;
use App\Services\Facebook;
use Throwable;
use function response;

class AppController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:app_read')->only('index', 'show');
        $this->middleware('permission:app_create')->only('store');
        $this->middleware('permission:app_update')->only('update');
        $this->middleware('permission:app_delete')->only('destroy');
    }

    public function index()
    {
        return App::all();
    }

    public function store(AppRequest $request)
    {
        $validatedData = $request->validated();
        try {
            $facebook = new Facebook();
            $clientId = $validatedData['client_id'];
            $clientSecret = $validatedData['client_secret'];
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

    public function update(AppRequest $request, App $app)
    {
        try {
            $validatedData = $request->validated();

            $facebook = new Facebook();
            $clientId = $validatedData['client_id'];
            $clientSecret = $validatedData['client_secret'];
            $oauthAccessToken = $facebook->oauthAccessToken($clientId, $clientSecret);

            if (isset($oauthAccessToken->error)) {
                return response()->json(['message' => $oauthAccessToken->error->message], 404);
            }

            $appInfo = $facebook->appInfo($clientId, $oauthAccessToken->access_token);

            if (isset($appInfo->error)) {
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
        } catch (Throwable $exception) {
            return response()->json($exception->getMessage(), 422);
        }
    }

    public function destroy(App $app)
    {
        $app->delete();

        return response()->json('App Deleted Successfully');
    }
}
