<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['title', 'desc'];

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'role_user');
    }
}
