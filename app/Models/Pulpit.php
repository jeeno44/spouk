<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pulpit extends Model
{
    protected $fillable = ['title', 'system_id', 'college_id'];

    public function disciplines()
    {
        return $this->hasMany(Discipline::class);
    }
}
