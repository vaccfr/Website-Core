<?php

namespace App\Models\Vatsim;

use Illuminate\Database\Eloquent\Model;

class UserFlight extends Model
{
    protected $table = "user_flights";

    protected $fillable = [
        'id',
        'vatsim_id',
        'callsign',
        'start',
        'end',
    ];
}
