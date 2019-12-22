<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogType extends Model
{
    protected $fillable = ['title', 'color', 'section', 'action'];
}
