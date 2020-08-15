<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;

class DiscordController extends Controller
{
    public function link()
    {
        $url = "https://discord.com/api/oauth2/authorize?client_id=744121480920563752&redirect_uri=".route('discord.redirect', app()->getLocale())."&response_type=code&scope=identify";

        return redirect($url);
    }

    public function redirectCode(Request $request)
    {
        $token_url = 'https://discord.com/api/oauth2/token';
        $user_url = 'https://discordapp.com/api/users/@me';

        try {
            $response = (new Client)->post($token_url, [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ],
                'form_params' => [
                    'client_id' => config('discordsso.client_id'),
                    'client_secret' => config('discordsso.client_secret'),
                    'grant_type' => 'authorization_code',
                    'code' => request('code'),
                    'redirect_uri' => route('discord.redirect', app()->getLocale()),
                    'scope' => 'identify'
                ]
            ]);
            $token_data = json_decode($response->getBody());
            $access_token = $token_data->access_token;
            $refresh_token = $token_data->refresh_token;
        } catch(ClientException $e){
            return redirect()->route('app.user.settings', app()->getLocale())->with("toast-error", 'Discord SSO error');
        }

        try {
            $response = (new Client)->get($user_url, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer '.$access_token,
                ]
            ]);
            $user_data = json_decode($response->getBody());

        } catch(ClientException $e){
            dd($e);
            return redirect()->route('app.user.settings', app()->getLocale())->with("toast-error", 'Discord SSO error');
        }
        dd($user_data);
    }
}
