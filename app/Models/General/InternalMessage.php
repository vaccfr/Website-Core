<?php

namespace App\Models\General;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class InternalMessage extends Model
{
    protected $table = "internal_messages";

    protected $fillable = [
        'id', 'sender_id', 'recipient_id', 'subject', 'body', 'read', 'read_at', 'archived', 'trashed',
    ];

    // Relationships

    public function sender()
    {
        return $this->hasOne(User::class, 'id', 'sender_id');
    }

    public function recipient()
    {
        return $this->hasOne(User::class, 'id', 'recipient_id');
    }
}
