<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;

class FeedbackForm extends Model
{
    protected $table = "feedback_forms";

    protected $fillable = [
        'id', 'name', 'vatsim_id', 'controller_cid', 'message',
    ];
}
