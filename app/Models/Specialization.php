<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    protected $fillable = ['title', 'code', 'college_id', 'kcp', 'subdivision_id', 'system_id', 'is_global'];

    public function groups()
    {
        return $this->hasMany('App\Models\SpecializationGroup', 'specialization_id');
    }

    public function candidates()
    {
        return $this->belongsToMany('App\Models\Candidate', 'specializations_candidates', 'specialization_id', 'candidate_id');
    }

    public function subdivision()
    {
        return $this->belongsTo('App\Models\Subdivision');
    }
}
