<?php

namespace App\Models\ATC;

use Illuminate\Database\Eloquent\Model;

class ATCRequest extends Model
{
    protected $table = "atc_requests";

    protected $fillable = [
        'id', 'name', 'vatsim_id', 'email', 'event_name', 'event_date', 'event_sponsors', 'event_website', 'dep_airport_and_time', 'arr_airport_and_time', 'requested_positions', 'expected_pilots', 'route', 'message',
        'assigned', 'responded',
    ];
}
