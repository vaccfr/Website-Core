<?php

namespace App\Models\CoFrance;

use Illuminate\Database\Eloquent\Model;

class StandApiData extends Model
{
    protected $table = "stand_api_data";

    protected $fillable = [
        'id', 'icao', 'stand', 'wtc', 'schengen', 'lat', 'lon', 'companies', 'usage', 'priority', 'is_open',
    ];
}
