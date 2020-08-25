<?php

namespace App\Models\Pilot;

use Illuminate\Database\Eloquent\Model;

class PilotStudent extends Model
{
    protected $table = "pilot_students";

    protected $fillable = [
        'id', 'vatsim_id', 'mentor_id', 'active', 'status', 'progress',
    ];

    // Relationships

    public function mentor()
    {
        return $this->hasOne(PilotMentor::class, 'mentor_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function sessions()
    {
        return $this->hasMany(PilotTrainingSession::class, 'student_id', 'id');
    }

    public function mentoringRequest()
    {
        return $this->hasOne(PilotMentoringRequest::class, 'student_id', 'id');
    }
}
