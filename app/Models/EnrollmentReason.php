<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnrollmentReason extends Model
{
    protected $fillable = ['college_id', 'system_id', 'title', 'is_global'];
}
