<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Users\DiscordData;
use App\Models\Users\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $ssocode = request('code');

        try {
            $response = (new Client)->post($token_url, [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ],
                'form_params' => [
                    'client_id' => config('discordsso.client_id'),
                    'client_secret' => config('discordsso.client_secret'),
                    'grant_type' => 'authorization_code',
                    'code' => $ssocode,
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
            return redirect()->route('app.user.settings', app()->getLocale())->with("toast-error", 'Discord SSO error');
        }

        $existing = DiscordData::where('user_id', auth()->user()->id)->first();
        if (is_null($existing)) {
            DiscordData::create([
                'user_id' => auth()->user()->id,
                'discord_id' => $user_data->id,
                'sso_code' => $ssocode,
                'username' => $user_data->username."#".$user_data->discriminator,
                'sso_access_token' => $access_token,
                'sso_refresh_token' => $refresh_token,
            ]);
        } else {
            $existing->discord_id = $user_data->id;
            $existing->sso_code = $ssocode;
            $existing->username = $user_data->username."#".$user_data->discriminator;
            $existing->sso_access_token = $access_token;
            $existing->sso_refresh_token = $refresh_token;
            $existing->save();
        }

        $user = Auth::user();
        $user->linked_discord = true;
        $user->save();

        return redirect()->route('app.user.settings', app()->getLocale())->with("toast-success", 'Discord Account Linked!');
    }

    public function unlink(Request $request)
    {
        $data = DiscordData::where('user_id', Auth::user()->id)->first();
        $user = User::where('id', Auth::user()->id)->first();

        if (is_null($data)) {
            return redirect()->route('app.user.settings', app()->getLocale())->with("toast-error", 'Error occured - Discord data not found');
        }

        $data->delete();
        $user->linked_discord = false;
        $user->save();

        return redirect()->route('app.user.settings', app()->getLocale())->with("toast-success", 'Discord Account Unlinked!');
    }
}
