<?php

namespace App\Models\CoFrance;

use Illuminate\Database\Eloquent\Model;

class CoFranceConfig extends Model
{
    protected $table = "co_france_configs";

    protected $fillable = [
        'type', 'content',
    ];
}
