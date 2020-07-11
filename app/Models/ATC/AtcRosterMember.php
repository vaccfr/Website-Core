<?php

namespace App\Models\ATC;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class AtcRosterMember extends Model
{
    protected $table = "atc_roster_members";

    protected $fillable = [
        'id', 'vatsim_id', 'fname', 'lname', 'rating', 'rating_short', 'rating_long', 'approved_flag',
    ];

    // Relationships

    public function user()
    {
        return $this->belongsTo(User::class, 'vatsim_id', 'vatsim_id');
    }
}
