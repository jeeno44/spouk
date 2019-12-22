<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sked extends Model
{
    protected $fillable = ['system_id', 'college_id', 'date', 'length', 'hall_id', 'discipline_id', 'course_id', 'hour_type_id', 'semester_id'];

    public function hall()
    {
        return $this->belongsTo(Hall::class);
    }

    public function discipline()
    {
        return $this->belongsTo(Discipline::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function hourType()
    {
        return $this->belongsTo(HourType::class);
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = date('Y-m-d H:i:s', strtotime($value));
    }

    public function setHallIdAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['hall_id'] = null;
        }
    }

    public function setLengthAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['length'] = 1;
        }
    }

}
