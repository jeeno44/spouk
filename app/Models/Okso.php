<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Okso extends Model
{
    protected $fillable = ['college_id', 'system_id', 'name', 'code', 'is_global'];
}
