<?php

namespace App\Http\Middleware\CoFrance;

use App\Models\CoFrance\CoFranceToken;
use App\Models\Users\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        $authToken = $request->header('auth');

        if (is_null($authToken)) {
            return response()->json([
                'message' => 'Unauthenticated.',
            ], 401);
        }

        $token = CoFranceToken::where('token', $authToken)->first();
        if (is_null($token)) {
            return response()->json([
                'message' => 'Unauthenticated.',
            ], 401);
        }
        $foundUser = User::where('id', $token->user_id)->first();
        if (is_null($foundUser)) {
            return response()->json([
                'message' => 'Error',
                'error' => 'user not found'
            ], 401);
        }
        Auth::setUser($foundUser);
        return $next($request);
    }
}
