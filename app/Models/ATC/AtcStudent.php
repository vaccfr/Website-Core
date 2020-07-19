<?php

namespace App\Models\ATC;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class AtcStudent extends Model
{
    protected $table = "atc_students";

    protected $fillable = [
        'id', 'vatsim_id', 'mentor_id', 'active',
    ];

    // Relationships

    public function mentor()
    {
        return $this->hasOne(Mentor::class, 'mentor_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }
}
