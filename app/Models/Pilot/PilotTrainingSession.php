<?php

namespace App\Models\Pilot;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class PilotTrainingSession extends Model
{
    protected $table = "pilot_training_sessions";

    protected $fillable = [
        'id', 'student_id', 'mentor_id', 'description', 'date', 'time', 'start_time', 'end_time',
        'requested_by', 'accepted_by_student', 'accepted_by_mentor', 'completed', 'status',
        'student_comment', 'mentor_comment', 'mentor_report',
    ];

    // Relationships

    public function student()
    {
        return $this->hasOne(User::class, 'student_id', 'id');
    }

    public function mentor()
    {
        return $this->hasOne(PilotMentor::class, 'id', 'mentor_id');
    }

    public function mentorUser()
    {
        return $this->hasOne(User::class, 'id', 'mentor_id');
    }
}
