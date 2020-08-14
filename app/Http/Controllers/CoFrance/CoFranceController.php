<?php

namespace App\Http\Controllers\CoFrance;

use App\Http\Controllers\Controller;
use App\Models\CoFrance\CoFranceToken;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CoFranceController extends Controller
{
    public function dashboard()
    {
        return view('app.atc.cofrance.dashboard');
    }

    public function createToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userid' => ['required'],
            'unique' => ['required', 'min:8'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('pop-error', 'Missing Data');
        }

        $oldToken = CoFranceToken::where('user_id', request('userid'))->first();
        if (!is_null($oldToken)) {
            $oldToken->delete();
        }

        $newValue = Str::random('64');
        $newToken = new CoFranceToken([
            'user_id' => request('userid'),
            'token' => $newValue,
            'password' => Hash::make(request('unique')),
        ]);
        $newToken->save();

        return redirect()->route('app.atc.cofrance.dashboard', app()->getLocale());
    }

    public function checkToken(Request $request)
    {
        $user = User::where('id', auth()->user()->id)
        ->select('vatsim_id', 'fname', 'is_approved_atc', 'is_betatester')
        ->first();

        return response()->json([
            'message' => 'Success',
            'user' => $user,
        ], 200);
    }
}
