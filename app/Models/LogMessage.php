<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogMessage extends Model
{
    protected $fillable = ['log_type_id', 'user_id', 'message', 'objects'];
}
