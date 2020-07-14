<?php

namespace App\Http\Controllers\DataHandlers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CacheController extends Controller
{
    public function checkCache($key, $private)
    {
        if ($private == true) {
            $suffix = "_".auth()->user()->vatsim_id;
            if (Cache::store('database')->has($key.$suffix)) {
                return true;
            } else {
                return false;
            }
        } else {
            if (Cache::store('database')->has($key)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function putCache($key, $data, $seconds, $private)
    {
        if ($private == true) {
            $suffix = "_".auth()->user()->vatsim_id;
            Cache::store('database')->put($key.$suffix, $data, $seconds);
        } else {
            Cache::store('database')->put($key, $data, $seconds);
        }
    }

    public function getCache($key, $private)
    {
        if ($private == true) {
            $suffix = "_".auth()->user()->vatsim_id;
            $cached = Cache::store('database')->get($key.$suffix);
        } else {
            $cached = Cache::store('database')->get($key);
        }
        return $cached;
    }
}
