<?php

namespace App\Models\Vatsim;

use Illuminate\Database\Eloquent\Model;

class UserAtcSession extends Model
{
    protected $table = "user_atc_sessions";

    protected $fillable = [
        'id', 'start', 'end', 'server', 'vatsim_id', 'type', 'rating',
        'callsign', 'times_held_callsign', 'minutes_on_callsign', 'total_minutes_on_callsign',
        'aircrafttracked', 'aircraftseen', 'flightsamended', 'handoffsinitiated', 'handoffsreceived',
        'handoffsrefused', 'squawksassigned', 'cruisealtsmodified', 'tempaltsmodified', 'scratchpadmods'
    ];
}
