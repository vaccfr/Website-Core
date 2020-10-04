<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class BannedUser extends Model
{
    protected $table = "banned_users";

    protected $primaryKey = "user_id";

    protected $fillable = [
        'user_id', 'vatsim_id', 'discord_id', 'reason',
    ];

    // Relationships

    public function user()
    {
        return $this->belongsTo(User::class, 'vatsim_id', 'vatsim_id');
    }
}
