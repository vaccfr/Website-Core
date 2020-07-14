<?php

namespace App\Http\Controllers\DataHandlers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CacheController extends Controller
{
    public function checkCache($key)
    {
        $suffix = "_".auth()->user()->vatsim_id;
        if (Cache::store('database')->has($key.$suffix)) {
            return true;
        } else {
            return false;
        }
    }

    public function putCache($key, $data, $seconds)
    {
        $suffix = "_".auth()->user()->vatsim_id;
        Cache::store('database')->put($key.$suffix, $data, $seconds);
    }

    public function getCache($key)
    {
        $suffix = "_".auth()->user()->vatsim_id;
        $cached = Cache::store('database')->get($key.$suffix);
        return $cached;
    }
}
