<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Model;

class ContactForm extends Model
{
    protected $table = "contact_forms";

    protected $fillable = [
        'id', 'name', 'vatsim_id', 'email', 'message', 'assigned', 'responded',
    ];
}
