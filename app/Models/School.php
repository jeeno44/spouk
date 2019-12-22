<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = ['title', 'address', 'phone', 'region_id', 'city_id', 'college_id', 'system_id'];

    public function region()
    {
        return $this->belongsTo('App\Models\Region');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }
}
