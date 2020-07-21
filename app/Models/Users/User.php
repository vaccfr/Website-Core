<?php

namespace App\Models\Users;

use App\Models\Admin\Staff;
use App\Models\ATC\AtcRosterMember;
use App\Models\ATC\Booking;
use App\Models\ATC\Mentor;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use function GuzzleHttp\json_decode;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = "users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'vatsim_id', 'fname', 'lname', 'email', 'custom_email', 'account_type', 'is_approved_atc',
        'atc_rating', 'atc_rating_short', 'atc_rating_long', 'pilot_rating', 
        'division_id', 'division_name', 'region_id', 'region_name', 'subdiv_id', 'subdiv_name',
        'is_staff', 'data_loaded',
    ];

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
        return $this->hasOne(AtcRosterMember::class, 'vatsim_id', 'vatsim_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'vatsim_id', 'vatsim_id');
    }

    public function atcmentor()
    {
        return $this->hasOne(Mentor::class, 'id', 'id');
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

    public function isStaff()
    {
        if ($this->is_staff == true) {
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

    public function isAtcMentor()
    {
        $user = Mentor::where('vatsim_id', $this->vatsim_id)->first();
        if (is_null($user)) {
            return false;
        }
        return true;
    }
}
