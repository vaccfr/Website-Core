<?php

namespace App\Http\Controllers\SSO;

use App\Events\Authentication\EventLogin;
use App\Events\Authentication\EventLogout;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DataHandlers\CacheController;
use App\Http\Controllers\DataHandlers\VatsimDataController;
use App\Models\Admin\Staff;
use App\Models\ATC\ATCRosterMember;
use App\Models\SSO\SSOToken;
use App\Models\Users\User;
use App\Models\Users\UserEmailPreference;
use App\Models\Users\UserSetting;
use App\Models\Vatsim\UserAtcSession;
use App\Models\Vatsim\UserFlight;
use Godruoyi\Snowflake\Snowflake;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    public function login($locale, $redir)
    {
        if (Auth::check()) {
            return redirect()->route('landingpage.home', app()->getLocale());
        }
        // session()->put('state', $state = Str::random(40));
        session()->forget('login_redir_url');
        if ($redir == "true") {
            session()->put('login_redir_url', url()->previous());
        }
        session()->forget('token');

        if (app()->getLocale() == "en") {
            $query = http_build_query([
                'client_id' => config('vatsimsso.en_client_id'),
                'redirect_uri' => config('vatsimsso.en_redirect'),
                'response_type' => 'code',
                'scope' => 'full_name vatsim_details email',
            ]);
        } else {
            $query = http_build_query([
                'client_id' => config('vatsimsso.fr_client_id'),
                'redirect_uri' => config('vatsimsso.fr_redirect'),
                'response_type' => 'code',
                'scope' => 'full_name vatsim_details email',
            ]);
        }
        
        return redirect(config('vatsimsso.url')."?".$query);
    }

    public function validateLogin(Request $request)
    {
        return view('app.login_redirect', [
            'code' => $request->code,
            'ip' => $request->ip(),
        ]);
    }

    public function computeLogin($locale, $code, $userip)
    {
        $previousUrl = session()->get('login_redir_url');
        session()->forget('login_redir_url');
        if (is_null($previousUrl)) {
            $previousUrl = route('app.index', app()->getLocale());
        }
        try {
            if (app()->getLocale() == "en") {
                $response = (new Client)->post('https://auth.vatsim.net/oauth/token', [
                    'form_params' => [
                        'grant_type' => 'authorization_code',
                        'client_id' => config('vatsimsso.en_client_id'),
                        'client_secret' => config('vatsimsso.en_secret'),
                        'redirect_uri' => config('vatsimsso.en_redirect'),
                        'code' => $code,
                    ],
                ]);
            } else {
                $response = (new Client)->post('https://auth.vatsim.net/oauth/token', [
                    'form_params' => [
                        'grant_type' => 'authorization_code',
                        'client_id' => config('vatsimsso.fr_client_id'),
                        'client_secret' => config('vatsimsso.fr_secret'),
                        'redirect_uri' => config('vatsimsso.fr_redirect'),
                        'code' => $code,
                    ],
                ]);
            }
        } catch(ClientException $e) {
            return redirect()->route('landingpage.home', app()->getLocale())->with("toast-error", trans('app/alerts.sso_error'));
        }

        $tokens = json_decode((string) $response->getBody(), true);

        session()->put('token', $tokens);

        try {
            $response = (new Client)->get('https://auth.vatsim.net/api/user', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer '.session()->get('token.access_token')
                ]
            ]);
        } catch(ClientException $e){
            return redirect()->route('landingpage.home', app()->getLocale())->with("toast-error", trans('app/alerts.sso_error'));
        }
        
        $response = json_decode($response->getBody());
        $existingUser = User::where('vatsim_id', $response->data->cid)->first();
        if (is_null($existingUser)) {
            $userid = (new Snowflake)->id();
        } else {
            $userid = $existingUser->id;
        }
        
        $user = User::where('vatsim_id', $response->data->cid)->first();

        if (is_null($user)) {
            User::create([
                'id' => $userid,
                'vatsim_id' => $response->data->cid,
                'email' => isset($response->data->personal->email) ? $response->data->personal->email : 'noemail@vatfrance.org',
                'fname' => isset($response->data->personal->name_first) ? $response->data->personal->name_first : null,
                'lname' => isset($response->data->personal->name_last) ? $response->data->personal->name_last : null,
                'atc_rating' => $response->data->vatsim->rating->id,
                'atc_rating_short' => $response->data->vatsim->rating->short,
                'atc_rating_long' => $response->data->vatsim->rating->long,
                'pilot_rating' => $response->data->vatsim->pilotrating->id,
                'region_id' => $response->data->vatsim->region->id,
                'region_name' => $response->data->vatsim->region->name,
                'division_id' => $response->data->vatsim->division->id,
                'division_name' => $response->data->vatsim->division->name,
                'subdiv_id' => $response->data->vatsim->subdivision->id,
                'subdiv_name' => $response->data->vatsim->subdivision->name,
            ]);
            $user = User::where('vatsim_id', $response->data->cid)->first();
            UserSetting::create([
                'id' => $userid,
                'vatsim_id' => $response->data->cid,
                'lang' => app()->getLocale(),
            ]);
        } else {
            $user->id = $userid;
            $user->vatsim_id = $response->data->cid;
            $user->email = isset($response->data->personal->email) ? $response->data->personal->email : 'noemail@vatfrance.org';
            $user->fname = isset($response->data->personal->name_first) ? $response->data->personal->name_first : null;
            $user->lname = isset($response->data->personal->name_last) ? $response->data->personal->name_last : null;
            $user->atc_rating = $response->data->vatsim->rating->id;
            $user->atc_rating_short = $response->data->vatsim->rating->short;
            $user->atc_rating_long = $response->data->vatsim->rating->long;
            $user->pilot_rating = $response->data->vatsim->pilotrating->id;
            $user->region_id = $response->data->vatsim->region->id;
            $user->region_name = $response->data->vatsim->region->name;
            $user->division_id = $response->data->vatsim->division->id;
            $user->division_name = $response->data->vatsim->division->name;
            $user->subdiv_id = $response->data->vatsim->subdivision->id;
            $user->subdiv_name = $response->data->vatsim->subdivision->name;
            $user->save();
        }

        $pref = UserEmailPreference::where('id', $userid)->first();
        if (is_null($pref)) {
            UserEmailPreference::create([
                'id' => $userid
            ]);
        }
        
        $rosterMember = ATCRosterMember::where('vatsim_id', $response->data->cid)->first();
        if (is_null($rosterMember)) {
            if ($user->subdiv_id == "FRA" && $user->atc_rating > 1) {
                ATCRosterMember::create([
                    'id' => $userid,
                    'vatsim_id' => $response->data->cid,
                    'fname' => isset($response->data->personal->name_first) ? $response->data->personal->name_first : null,
                    'lname' => isset($response->data->personal->name_last) ? $response->data->personal->name_last : null,
                    'rating' => $response->data->vatsim->rating->id,
                    'rating_short' => $response->data->vatsim->rating->short,
                    'approved_flag' => false,
                ]);
            } elseif (!is_null($rosterMember)) {
                $rosterMember->delete();
            }
        } else {
            if ($user->subdiv_id == "FRA" && $user->atc_rating > 1) {
                $rosterMember->id = $userid;
                $rosterMember->vatsim_id = $response->data->cid;
                $rosterMember->fname = isset($response->data->personal->name_first) ? $response->data->personal->name_first : null;
                $rosterMember->lname = isset($response->data->personal->name_last) ? $response->data->personal->name_last : null;
                $rosterMember->rating = $response->data->vatsim->rating->id;
                $rosterMember->rating_short = $response->data->vatsim->rating->short;
                $rosterMember->save();
            } elseif (!is_null($rosterMember)) {
                $rosterMember->delete();
            }
        }

        SSOToken::updateOrCreate(['vatsim_id' => $response->data->cid], [
            'id' => $userid,
            'access_token' => $tokens['access_token'],
            'refresh_token' => $tokens['refresh_token'],
        ]);

        if ($user->vatsim_id == '1267123') {
            Staff::updateOrCreate(['vatsim_id' => $user->vatsim_id], [
                'id' => $userid,
                'staff_level' => 0,
                'admin' => true,
                'atc_dpt' => true,
                'executive' => true,
            ]);
            $user->is_staff = true;
            $user->save();
        }

        Auth::login($user, true);

        event(new EventLogin($user, $userip));

        return redirect()->to($previousUrl)->with("toast-success", trans('app/alerts.logged_in'));
        // return redirect()->route('app.index', app()->getLocale())->with("toast-success", trans('app/alerts.logged_in'));
    }

    public function logout()
    {
        $user = Auth::user();
        Auth::logout();
        event(new EventLogout($user));
        return redirect()->route('landingpage.home', app()->getLocale())->with("toast-success", trans('app/alerts.logged_out'));
    }
}
