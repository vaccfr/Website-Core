<?php

namespace App\Http\Controllers\DataHandlers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class Utilities extends Controller
{
    public function timeConverter($dec, $withSeconds)
    {
        // start by converting to seconds
        $seconds = ($dec * 3600);
        // we're given hours, so let's get those the easy way
        $hours = floor($dec);
        // since we've "calculated" hours, let's remove them from the seconds variable
        $seconds -= $hours * 3600;
        // calculate minutes left
        $minutes = floor($seconds / 60);
        // remove those from seconds as well
        $seconds -= $minutes * 60;
        // return the time formatted HH:MM:SS
        if ($withSeconds == true) {
            return $this->lz($hours).":".$this->lz($minutes).":".$this->lz($seconds);
        } else {
            return $this->lz($hours).":".$this->lz($minutes);
        }
    }
    // lz = leading zero
    protected function lz($num)
    {
        return (strlen($num) < 2) ? "0{$num}" : $num;
    }

    public function decMinConverter($dec, $withSeconds)
    {
        $minutes = floor($dec);
        $seconds = (60 / 100 * (($dec - $minutes)*100));
        $seconds = $seconds + ($minutes*60);
        $t = round($seconds);
        $time = sprintf('%02d:%02d:%02d', ($t/3600),($t/60%60), $t%60);
        return $time;
    }
    
    public function iso2datetime($data)
    {
        $format = 'Y/m/d - H:i:s';
        return date_format(date_create($data), $format);
    }

    public function getAuthedRanks($userrank)
    {
        if ($userrank == "OBS") {
            return ["OBS"];
        } elseif ($userrank == "S1") {
            return ["S1"];
        } elseif ($userrank == "S2") {
            return ["S1", "S2"];
        } elseif ($userrank == "S3") {
            return ["S1", "S2", "S3"];
        } elseif ($userrank == "C1") {
            return ["S1", "S2", "S3", "C1"];
        } else {
            return ["S1", "S2", "S3", "C1"];
        }
    }
}
