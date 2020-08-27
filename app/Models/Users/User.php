<?php

namespace App\Models\Users;

use App\Models\Admin\Staff;
use App\Models\ATC\ATCRosterMember;
use App\Models\ATC\Booking;
use App\Models\ATC\Mentor;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;

use function GuzzleHttp\json_decode;

class User extends Authenticatable
{
    use Notifiable, LogsActivity;

    protected $table = "users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'vatsim_id', 'fname', 'lname', 'email', 'custom_email', 'account_type', 'is_approved_atc', 'is_approved_visiting_atc',
        'atc_rating', 'atc_rating_short', 'atc_rating_long', 'pilot_rating', 
        'division_id', 'division_name', 'region_id', 'region_name', 'subdiv_id', 'subdiv_name',
        'is_staff', 'is_betatester', 'linked_discord', 'hide_details', 'last_login', 'login_ip',
    ];
    
    protected static $logName = 'user';
    protected static $logAttributes  = [
        'id', 'vatsim_id', 'fname', 'lname', 'email', 'custom_email', 'account_type', 'is_approved_atc',
        'atc_rating_short', 'pilot_rating', 'is_staff',
    ];
    // protected static $ignoreChangedAttributes = ['vatsim_id', 'fname', 'lname', 
    // 'division_id', 'division_name', 'region_id', 'region_name', 'subdiv_id', 'subdiv_name',
    // 'is_staff', 'hide_details', 'last_login', 'login_ip', 'updated_at',];
    protected static $logOnlyDirty = true;
    public function getDescriptionForEvent(string $eventName): string
    {
        return "User {$eventName}";
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    // Relationships

    public function settings()
    {
        return $this->hasOne(UserSetting::class, 'vatsim_id', 'vatsim_id');
    }

    public function staff()
    {
        return $this->hasOne(Staff::class, 'vatsim_id', 'vatsim_id');
    }

    public function atcroster()
    {
        return $this->hasOne(ATCRosterMember::class, 'vatsim_id', 'vatsim_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'vatsim_id', 'vatsim_id');
    }

    public function atcmentor()
    {
        return $this->hasOne(Mentor::class, 'id', 'id');
    }

    public function discord()
    {
        return $this->hasOne(DiscordData::class, 'user_id', 'id');
    }

    // Utility Functions
    
    public function fullname()
    {
        return $this->fname." ".$this->lname;
    }

    public function fullAtcRank()
    {
        $fullrank = $this->atc_rating_short." (".$this->atc_rating_long.")";
        return $fullrank;
    }

    public function isATC()
    {
        $rep = false;
        if (strpos($this->account_type, 'ATC')) {
            $rep = true;
        }
        return $rep;
    }

    public function isApprovedAtc()
    {
        $rep = false;
        if ($this->is_approved_atc == true) {
            $rep = true;
        }
        return $rep;
    }

    public function isApprovedVisitingAtc()
    {
        $rep = false;
        if ($this->is_approved_visiting_atc == true) {
            $rep = true;
        }
        return $rep;
    }

    public function isStaff()
    {
        if ($this->is_staff == true) {
            return true;
        } else {
            return false;
        }
    }

    public function isBetaTester()
    {
        if ($this->is_betatester == true) {
            return true;
        } else {
            return false;
        }
    }

    public function isAdmin()
    {
        $user = Staff::where('vatsim_id', $this->vatsim_id)->first();
        if (is_null($user)) {
            return false;
        }
        if ($user->admin == false) {
            return false;
        }
        return true;
    }

    public function isExecStaff()
    {
        $user = Staff::where('vatsim_id', $this->vatsim_id)->first();
        if (is_null($user)) {
            return false;
        }
        if ($user->executive == false) {
            return false;
        }
        return true;
    }

    public function isEventsStaff()
    {
        $user = Staff::where('vatsim_id', $this->vatsim_id)->first();
        if (is_null($user)) {
            return false;
        }
        if ($user->events == false) {
            return false;
        }
        return true;
    }

    public function isAtcMentor()
    {
        $user = Mentor::where('vatsim_id', $this->vatsim_id)->first();
        if (is_null($user)) {
            return false;
        }
        return true;
    }

    public function isPilotMentor()
    {
        $user = Staff::where('vatsim_id', $this->vatsim_id)->first();
        if (is_null($user)) {
            return false;
        } elseif ($user->pilot_dpt == 1) {
            return true;
        }
        return false;
    }

    public function hiddenDetails()
    {
        if ($this->hide_details == true) {
            return true;
        }
        return false;
    }

    public function emailPreferences()
    {
        $pref = UserEmailPreference::where('id', $this->id)->first();
        return $pref;
    }

    public function sidenavCollapsed()
    {
        $curr = UserSetting::where('vatsim_id', $this->vatsim_id)->first();
        return $curr['sidenav_collapsed'];
    }
}
