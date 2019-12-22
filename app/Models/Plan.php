<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = ['title', 'approved_date', 'year', 'plan_status_id', 'system_id', 'college_id'];

    public function status()
    {
        return $this->belongsTo(PlanStatus::class, 'plan_status_id', 'id');
    }

    public function setApprovedDateAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['approved_date'] = date('Y-m-d', strtotime($value));
        } else {
            $this->attributes['approved_date'] = '0000-00-00';
        }
    }

    public function getApprovedDateAttribute($value)
    {
        if ($value == '0000-00-00') {
            return '';
        }
        return date('d.m.Y', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d.m.Y', strtotime($value));
    }
}
