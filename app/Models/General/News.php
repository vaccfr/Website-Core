<?php

namespace App\Models\General;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = "news";

    protected $fillable = [
        'id', 'title', 'content', 'published', 'author_id', 'discord_msg_id',
    ];

    // Relationships

    public function author()
    {
        return $this->hasOne(User::class, 'id', 'author_id');
    }
}
