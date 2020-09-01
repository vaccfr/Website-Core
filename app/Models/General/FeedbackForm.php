<?php

namespace App\Models\General;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class FeedbackForm extends Model
{
    protected $table = "feedback_forms";

    protected $fillable = [
        'id', 'name', 'vatsim_id', 'controller_cid', 'position', 'occurence_date', 'message',
    ];

    // Relationships

    public function target()
    {
        return $this->hasOne(User::class, 'vatsim_id', 'controller_cid');
    }
}
