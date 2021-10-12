<?php

namespace App\Services;

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
}
