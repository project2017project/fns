<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    protected $fillable = ['photo','title','details','time'];
    public $timestamps = false;
}
