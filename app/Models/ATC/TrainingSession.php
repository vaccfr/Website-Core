<?php

namespace App\Models\ATC;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class TrainingSession extends Model
{
    protected $table = "training_sessions";

    protected $fillable = [
        'id', 'student_id', 'mentor_id', 'position', 'date', 'time', 'start_time', 'end_time',
        'requested_by', 'accepted_by_student', 'accepted_by_mentor', 'completed', 'status',
        'booking_id', 'student_comment', 'mentor_comment', 'mentor_report',
    ];

    // Relationships

    public function student()
    {
        return $this->hasOne(User::class, 'student_id', 'id');
    }
    
    public function mentor()
    {
        return $this->hasOne(Mentor::class, 'id', 'mentor_id');
    }

    public function mentorUser()
    {
        return $this->hasOne(User::class, 'id', 'mentor_id');
    }

    public function booking()
    {
        return $this->hasOne(Booking::class, 'booking_id', 'id');
    }

    // Functions
}
