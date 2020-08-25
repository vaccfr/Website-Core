<?php

namespace App\Models\Pilot;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class PilotMentor extends Model
{
    protected $table = "pilot_mentors";

    protected $fillable = [
        'id', 'vatsim_id', 'allowed_rank', 'student_count', 'active',
    ];

    // Relationships

    public function user()
    {
        return $this->belongsTo(User::class, 'vatsim_id', 'vatsim_id');
    }
}
