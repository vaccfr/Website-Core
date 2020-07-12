<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    protected $table = "user_settings";

    protected $fillable = [
        'id', 'vatsim_id', 'lang',
    ];

    // Relationships

    public function user()
    {
        return $this->belongsTo(User::class, 'vatsim_id', 'vatsim_id');
    }

    public function lastLang()
    {
        $lang = $this->lang;
        return $lang;
    }
}
