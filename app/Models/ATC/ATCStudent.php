<?php

namespace App\Models\ATC;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class ATCStudent extends Model
{
    protected $table = "atc_students";

    protected $fillable = [
        'id', 'vatsim_id', 'mentor_id', 'active', 'status', 'progress',
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

    public function sessions()
    {
        return $this->hasMany(TrainingSession::class, 'student_id', 'id');
    }

    public function mentoringRequest()
    {
        return $this->hasOne(MentoringRequest::class, 'student_id', 'id');
    }
}
