<?php

namespace App\Models\ATC;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class ATCRosterMember extends Model
{
    protected $table = "atc_roster_members";

    protected $fillable = [
        'id', 'vatsim_id', 'fname', 'lname', 'rating', 'rating_short', 'visiting', 'approved_flag',
        'appr_lfpg_twr', 'appr_lfpg_app', 'appr_lfmn_twr', 'appr_lfmn_app', 
    ];

    // Relationships

    public function user()
    {
        return $this->belongsTo(User::class, 'vatsim_id', 'vatsim_id');
    }
}
