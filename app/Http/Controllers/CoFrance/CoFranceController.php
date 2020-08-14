<?php

namespace App\Http\Controllers\CoFrance;

use App\Http\Controllers\Controller;
use App\Models\CoFrance\CoFranceToken;
use Illuminate\Http\Request;
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
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('pop-error', 'Missing User ID');
        }

        $oldToken = CoFranceToken::where('user_id', request('userid'))->first();
        if (!is_null($oldToken)) {
            $oldToken->delete();
        }

        $newValue = Str::random('64');
        $newToken = new CoFranceToken([
            'user_id' => request('userid'),
            'token' => $newValue,
        ]);
        $newToken->save();

        return redirect()->route('app.atc.cofrance.dashboard', app()->getLocale());
    }
}
