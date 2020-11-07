<?php

namespace App\Models\Data;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class ShortUrl extends Model
{
    protected $table = "short_urls";

    protected $fillable = [
        "user_id", "short", "url",
    ];

    // Relationships
    public function author()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
