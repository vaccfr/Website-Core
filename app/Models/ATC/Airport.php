<?php

namespace App\Models\ATC;

use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    protected $table = 'airports';

    protected $fillable = [
        'icao', 'fir', 'city', 'airport', 'atis_frequency'
    ];

    // Relationships

    public function positions()
    {
        return $this->hasMany(ATCStation::class, 'airport_id');
    }
}
