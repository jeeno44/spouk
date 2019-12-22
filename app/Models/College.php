<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    protected $fillable = ['title', 'region_id', 'city_id', 'address', 'phone'];

    public function region()
    {
        return $this->belongsTo('App\Models\Region');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function systems()
    {
        return $this->belongsToMany('App\Models\System', 'college_system');
    }

    public function candidates()
    {
        return $this->hasMany('App\Models\Candidate');
    }

    public function users()
    {
        return $this->hasMany('App\Models\User');
    }

    public function specializations()
    {
        return $this->hasMany('App\Models\Specialization');
    }


}
