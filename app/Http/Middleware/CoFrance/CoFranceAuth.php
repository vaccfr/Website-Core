<?php

namespace App\Http\Middleware\CoFrance;

use App\Models\CoFrance\CoFranceToken;
use App\Models\Users\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yosymfony\Toml\TomlBuilder;

class CoFranceAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $tb = new TomlBuilder();
        $error = $tb
        ->addTable('request')
        ->addValue('code', 401)
        ->addValue('type', 'error')
        ->addValue('message', 'Unauthenticated.')
        ->getTomlString();

        $authToken = $request->header('auth');

        if (is_null($authToken)) {
            return response($error, 401)->header('Content-Type', 'application/toml');
        }

        $token = CoFranceToken::where('token', $authToken)->first();
        if (is_null($token)) {
            return response($error, 401)->header('Content-Type', 'application/toml');
        }
        $foundUser = User::where('id', $token->user_id)->first();
        if (is_null($foundUser)) {
            return response($error, 401)->header('Content-Type', 'application/toml');
        }
        Auth::setUser($foundUser);
        return $next($request);
    }
}
