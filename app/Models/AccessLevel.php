<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessLevel extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'access_level_user', 'access_level_id', 'user_id');
    }

    protected $fillable = ['title', 'desc'];
}
