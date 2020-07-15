<?php

namespace App\Models\ATC;

use Illuminate\Database\Eloquent\Model;

class ATCStation extends Model
{
    protected $table = 'atc_stations';

    protected $fillable = [
        'airport_id', 'code', 'type', 'frequency', 'rank', 'solo_rank',
    ];

    // Relationships

    public function parent()
    {
        return $this->hasOne(Airport::class, 'id', 'airport_id');
    }
}
