<?php

namespace App\Models\CoFrance;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class CoFranceToken extends Model
{
    protected $table = "co_france_tokens";

    protected $fillable = [
        'user_id', 'token', 'last_used', 'last_ip', 'password'
    ];

    protected $hidden = [
        'password',
    ];

    // Relationships

    public function user()
    {
        return $this->hasOne(User::class, 'user_id', 'id');
    }
}
