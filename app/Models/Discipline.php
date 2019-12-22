<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discipline extends Model
{
    protected $fillable = ['title', 'system_id', 'pulpit_id', 'code', 'college_id', 'hall_id'];
    
    public function pulpit()
    {
        return $this->belongsTo(Pulpit::class);
    }

    public function hall()
    {
        return $this->belongsTo(Hall::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class,'discipline_user', 'discipline_id', 'user_id');
    }

    public function hasTeacher($check)
    {
        return in_array($check, array_pluck($this->users->toArray(), 'id'));
    }

    public function competences()
    {
        return $this->belongsToMany(Competence::class,'discipline_competence');
    }

    public function hasCompetence($check)
    {
        return in_array($check, array_pluck($this->competences->toArray(), 'id'));
    }
}
