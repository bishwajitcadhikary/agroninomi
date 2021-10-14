<?php

namespace App\Services;

use App\Models\User;
use Http;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class Facebook
{
    public function oauthAccessToken($clientId, $clientSecret)
    {
        $response = \Http::get("https://graph.facebook.com/v12.0/oauth/access_token?client_id=".$clientId."&client_secret=".$clientSecret."&grant_type=client_credentials");
        return json_decode($response);
    }

    public function appInfo($clientId, $accessToken, $fields = ['name', 'photo_url'])
    {
        $response = \Http::get("https://graph.facebook.com/v12.0/".$clientId."?fields=".implode(',', $fields).",link&access_token=".$accessToken);

        return json_decode($response);
    }

    public function searchPages($name, $fields = ['id', 'name', 'location', 'link', 'is_eligible_for_branded_content', 'is_unclaimed', 'verification_status'])
    {
        $user = User::role('admin')
            ->inRandomOrder()
            ->limit(10)
            ->whereHas('apps')
            ->with('apps')
            ->firstOrFail();

        $app = $user->apps()->inRandomOrder()->limit(5)->firstOrFail();

        $url = "https://graph.facebook.com/pages/search?q=" . $name . "&fields=" . $fields . "&access_token=" . $app->client_id . '|' . $app->client_secret;
        $response = Http::get($url);
        $data = json_decode($response);

        if (isset($data->error)) {
            return $data;
        }

        if (isset($data->data)) {
            return $data;
        }

        return ['error' => ['message' => 'Something Went Wrong']];
    }
}
