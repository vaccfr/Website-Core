<?php

namespace App\Models\Data;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
    protected $table = "system_logs";

    protected $fillable = [
        'type', 'user_id', 'message', 'url', 'line', 'file'
    ];

    public static function exception($type, $user, $message, $url, $line, $file) {
        $log = new self;
        $log->type = $type;
        $log->user_id = $user;
        $log->message = $message;
        $log->url = $url;
        $log->line = $line;
        $log->file = $file;
        $log->save();
    }

    // Relationships

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Functions

    public function type() {
        switch ($this->type) {
            case 0:
                return 'Error';
            
            case 1:
                return 'Success';
            
            case 2:
                return 'Exception';

            default:
                return 'Exception';
        }
    }
}
