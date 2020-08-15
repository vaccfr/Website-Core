<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class DiscordData extends Model
{
    protected $table = "discord_data";

    protected $fillable = [
        'user_id', 'discord_id', 'username', 'banned', 'sso_code', 'sso_access_token', 'sso_refresh_token',
    ];

    // Relationships

    public function user()
    {
        return $this->hasOne(User::class, 'user_id', 'id');
    }
}
