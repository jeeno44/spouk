<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanStatusHistory extends Model
{
    protected $fillable = ['plan_id', 'plan_status_id'];

    public function status()
    {
        return $this->belongsTo(PlanStatus::class, 'plan_status_id', 'id');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id', 'id');
    }
}
