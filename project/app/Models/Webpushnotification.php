<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Webpushnotification extends Model
{
    protected $fillable = [
        'title',
        'message',
        'target_url',
        'image'
    ];
    public $timestamps = false;
}
