<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function region()
    {
        return $this->belongsTo('App\Models\Region');
    }
}
