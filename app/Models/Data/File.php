<?php

namespace App\Models\Data;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = "files";

    protected $fillable = [
        'id', 'name', 'url',
    ];

    // Relationships

    // Functions
}
