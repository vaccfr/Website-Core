<?php

namespace App\Models\Pilot;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class PilotMentoringRequest extends Model
{
    protected $table = "pilot_mentoring_requests";

    protected $fillable = [
        'id', 'student_id', 'motivation', 'mail_consent', 'taken', 'mentor_id'
    ];

    // Relationships

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'student_id');
    }

    public function mentor()
    {
        return $this->hasOne(PilotMentor::class, 'id', 'mentor_id');
    }
}
