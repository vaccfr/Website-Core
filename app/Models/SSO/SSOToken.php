<?php

namespace App\Models\SSO;

use Illuminate\Database\Eloquent\Model;

class SSOToken extends Model
{
    protected $table = "sso_tokens";

    protected $fillable = [
        'id', 'vatsim_id', 'access_token', 'refresh_token',
    ];
}
