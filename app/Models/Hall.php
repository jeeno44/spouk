<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    protected $fillable = ['title', 'system_id', 'pulpit_id', 'code', 'college_id'];
}
