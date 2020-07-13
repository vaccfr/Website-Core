<?php

namespace App\Models\Users;

use App\Models\Admin\Staff;
use App\Models\ATC\AtcRosterMember;
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
        'vatsim_id', 'fname', 'lname', 'email', 'account_type', 
        'atc_rating', 'atc_rating_short', 'atc_rating_long', 'pilot_rating', 
        'division_id', 'division_name', 'region_id', 'region_name', 'subdiv_id', 'subdiv_name',
        'is_staff', 'staff_level',
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
    
    public function totalTimes()
    {
        $cid = $this->vatsim_id;
        try {
            $response = (new Client)->get('https://api.vatsim.net/api/ratings/'.$cid.'/rating_times', [
                'header' => [
                    'Accept' => 'application/json',
                ]
            ]);
            $response = json_decode((string) $response->getBody(), true);
            $return = [
                'atc' => $response['atc'],
                'pilot' => $response['pilot'],
            ];
        } catch(ClientException $e) {
            $return = [
                'atc' => 'Api Error',
                'pilot' => 'Api Error',
            ];
        }
        return $return;
    }
}
