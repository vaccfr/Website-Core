<?php

namespace App\Http\Controllers\DataHandlers;

use App\Http\Controllers\Controller;
use App\Models\Users\UserEmailPreference;
use DateTime;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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

    public function checkEmailPreference($userid, $type)
    {
        switch ($type) {
            case 'event':
                $pref = UserEmailPreference::where('id', $userid)->first();
                if (!is_null($pref)) {
                    return $pref->event_emails;
                } else {
                    return true;
                }
                break;
            
            case 'atc_booking':
                $pref = UserEmailPreference::where('id', $userid)->first();
                if (!is_null($pref)) {
                    return $pref->atc_booking_emails;
                } else {
                    return true;
                }
                break;
            
            case 'atc_mentoring':
                $pref = UserEmailPreference::where('id', $userid)->first();
                if (!is_null($pref)) {
                    return $pref->atc_mentoring_emails;
                } else {
                    return true;
                }
                break;
                
            case 'website_update':
                $pref = UserEmailPreference::where('id', $userid)->first();
                if (!is_null($pref)) {
                    return $pref->website_update_emails;
                } else {
                    return true;
                }
                break;

            case 'news':
                $pref = UserEmailPreference::where('id', $userid)->first();
                if (!is_null($pref)) {
                    return $pref->news_emails;
                } else {
                    return true;
                }
                break;

            case 'internal_message':
                $pref = UserEmailPreference::where('id', $userid)->first();
                if (!is_null($pref)) {
                    return $pref->internal_messaging_emails;
                } else {
                    return true;
                }
                break;
            
            default:
                return false;
                break;
        }
    }

    public function onlineUsers()
    {
        $delay = 300;
        if (app(CacheController::class)->checkCache('onlineUsers', false)) {
            $data = app(CacheController::class)->getCache('onlineUsers', false);
        } else {
            $timeDelta = (new DateTime(Carbon::now()))->format('U');
            $timeDelta = (int)$timeDelta - $delay;

            $liveVisitors = DB::table('sessions')
            ->where('last_activity', '>', $timeDelta)
            ->where('user_id', null, null)
            ->where('user_agent', '!=', 'python-requests/2.22.0')
            ->get();

            $liveMembers = DB::table('sessions')
            ->where('last_activity', '>', $timeDelta)
            ->where('user_id', '!=', null)
            ->get();

            $data = [
                'members' => count($liveMembers),
                'visitors' => count($liveVisitors),
            ];

            // app(CacheController::class)->putCache('onlineUsers', $data, 60, false);
        }

        return $data;
    }

    public function getDiscordOnlineUsers()
    {
        $url = "https://discordapp.com/api/guilds/649009573692440594/widget.json";

        if (app(CacheController::class)->checkCache('discordOnlineUsers', false)) {
            $clients = app(CacheController::class)->getCache('discordOnlineUsers', false);
        } else {
            $clients = 0;
            try {
                $response = (new Client)->get($url);
                $response = json_decode((string) $response->getBody(), true);
                $clients = $response['presence_count'];
            } catch(\Throwable $e) {
                $clients = 'N/A';
            }
            
            app(CacheController::class)->putCache('discordOnlineUsers', $clients, 30, false);
        }
        return $clients;
    }
}
