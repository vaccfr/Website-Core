<?php

namespace App\Models\Vatsim;

use Illuminate\Database\Eloquent\Model;

class UserConnections extends Model
{
    protected $table = "user_connections";

    protected $fillable = [
        'id',
        'vatsim_id',
        'type',
        'rating',
        'callsign',
        'start',
        'end',
        'server',
    ];
    
}
