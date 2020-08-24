<?php

namespace App\Models\General;

use App\Models\Data\File;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = "events";

    protected $fillable = [
        'id', 'title', 'description', 'url', 'date', 'start_time', 'end_time', 'has_image', 'image_id', 'image_url', 'publisher_id',
    ];

    // Relationships

    public function image()
    {
        return $this->hasOne(File::class, 'image_id', 'id');
    }

    public function publisher()
    {
        return $this->hasOne(User::class, 'publisher_id', 'id');
    }
}
