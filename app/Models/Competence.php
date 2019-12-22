<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competence extends Model
{
    protected $fillable = ['title', 'system_id', 'pulpit_id', 'code', 'college_id'];

    public function disciplines()
    {
        return $this->belongsToMany(Discipline::class,'discipline_competence');
    }

    public function hasDiscipline($check)
    {
        return in_array($check, array_pluck($this->disciplines->toArray(), 'id'));
    }
}
