<?php

namespace App\Http\Controllers\CoFrance;

use App\Http\Controllers\Controller;
use App\Models\CoFrance\CoFranceConfig;
use App\Models\CoFrance\CoFranceToken;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yosymfony\Toml\Toml;
use Yosymfony\Toml\TomlBuilder;

class CoFranceController extends Controller
{
    public function dashboard()
    {
        $currtoken = null;
        $tokens = CoFranceToken::where('user_id', auth()->user()->id)->first();
        if (!is_null($tokens)) {
            $currtoken = $tokens->token;
        }

        $currConfig = null;
        $config = CoFranceConfig::where('type', 'lvlownership')->first();
        if (!is_null($config)) {
            $currConfig = $config->content;
        }
        return view('app.atc.cofrance.dashboard', [
            'token' => $currtoken,
            'editorContent' => $currConfig,
        ]);
    }

    public function createToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userid' => ['required'],
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
        ]);
        $newToken->save();

        return redirect()->route('app.atc.cofrance.dashboard', app()->getLocale());
    }

    public function checkToken(Request $request)
    {
        $user = User::where('id', auth()->user()->id)
        ->select('is_approved_atc', 'is_betatester')
        ->first();

        $tb = new TomlBuilder();
        $result = $tb
        ->addTable('request')
        ->addValue('code', 200)
        ->addValue('type', 'success')
        ->addTable('user')
        ->addValue('is_approved_atc', $user['is_approved_atc'])
        ->addValue('is_betatester', $user['is_betatester'])
        ->getTomlString();

        return response($result, 200)->header('Content-Type', 'application/toml');
    }

    public function test(Request $request)
    {
        $tb = new TomlBuilder();
        $result = $tb->addComment('Toml file')
        ->addTable('data.string')
        ->addValue('name', "Toml", 'This is your name')
        ->addValue('newline', "This string has a \n new line character.")
        ->addValue('winPath', "C:\\Users\\nodejs\\templates")
        ->addValue('literal', '@<\i\c*\s*>') // literals starts with '@'.
        ->addValue('unicode', 'unicode character: ' . json_decode('"\u03B4"'))
        ->getTomlString();
        $result = "[random]\nfirst_var = my_value\n[other.stuff]\neven_more_stuff = cool_shiz";
        return response($result, 200)->header('Content-Type', 'application/toml');
    }

    public function sendConfig(Request $request)
    {
        $tb = new TomlBuilder();
        $result = $tb
        ->addTable('request')
        ->addValue('code', 200)
        ->addValue('type', 'success')
        ->getTomlString();

        $config = CoFranceConfig::where('type', 'lvlownership')->first();
        $config = $config['content'];
        $result .= "\n";
        $result .= $config;
        return response($result, 200)->header('Content-Type', 'application/toml');
    }

    public function storeConfig(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'editor' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('pop-error', 'Missing Data');
        }

        $oldConfig = CoFranceConfig::where('type', 'lvlownership')->first();
        if (!is_null($oldConfig)) {
            $oldConfig->delete();
        }

        $newValue = nl2br($request->get('editor'));
        $newConfig = new CoFranceConfig([
            'type' => 'lvlownership',
            'content' => $request->get('editor'),
        ]);
        $newConfig->save();
        return redirect()->route('app.atc.cofrance.dashboard', app()->getLocale());
    }
}
