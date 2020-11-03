<?php

namespace App\Http\Controllers\CoFrance;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DataHandlers\VatsimDataController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SSRApiController extends Controller
{
    protected $ssr_range = [5600, 5777];

    public function query(Request $request)
    {
        $CurrentlyOnlinePilots = app(VatsimDataController::class)->getOnlinePilots(); // cache of 150 seconds

        $codes = $this->getAvailableSSR($this->ssr_range);
        $takenCodes = [];
        $finalCodes = [];

        foreach ($CurrentlyOnlinePilots as $idx => $p) {
            $vertices_x = array(-7.50, 9, 10.1, -7.50);
            $vertices_y = array(51, 51, 40.1, 40.6);
            $point_polygon = count($vertices_x);
            $longitude_x = $p['lon'];
            $latitude_y = $p['lat'];

            if ($this->is_in_polygon($point_polygon, $vertices_x, $vertices_y, $longitude_x, $latitude_y)) {
                array_push($takenCodes, $p['ssr']);
            }
        }
        foreach ($codes as $c) {
            if (!in_array($c, $takenCodes)) {
                array_push($finalCodes, $c);
            }
        }
        
        if (count($finalCodes) > 0) {
            $foundValidCode = false;
            $cycleCode = 0;
            while ($foundValidCode == false) {
                if ($this->cacheChecker($finalCodes[$cycleCode]) == false) {
                    $foundValidCode = true;
                    $result = $finalCodes[$cycleCode];
                } else {
                    $cycleCode++;
                }
            }
        } else {
            $result = $codes[rand(0,count($codes)-1)];
        }

        return response($result, 200)->header('Content-Type', 'text/plain');
    }

    private function is_in_polygon($points_polygon, $vertices_x, $vertices_y, $longitude_x, $latitude_y)
    {
        $i = $j = $c = 0;
        for ($i = 0, $j = $points_polygon-1 ; $i < $points_polygon; $j = $i++) {
            if ( (($vertices_y[$i] > $latitude_y != ($vertices_y[$j] > $latitude_y)) &&
            ($longitude_x < ($vertices_x[$j] - $vertices_x[$i]) * ($latitude_y - $vertices_y[$i]) / ($vertices_y[$j] - $vertices_y[$i]) + $vertices_x[$i]) ) ) 
                $c = !$c;
        }
        return $c;
    }

    private function getAvailableSSR($range)
    {
        $codes = [];
        $i = $range[0];
        while ($i < $range[1]+1) {
            if (!strpos((string)$i, "8") && !strpos((string)$i, "9")) {
                array_push($codes, $i);
            }
            $i++;
        }
        return $codes;
    }

    private function cacheChecker($ssr)
    {
        if (Cache::store('database')->has("ssr_cache_".$ssr)) {
            return true;
        } else {
            Cache::store('database')->put("ssr_cache_".$ssr, true, 900);
            return false;
        }
    }
}