<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanDiscipline extends Model
{
    protected $fillable = [
        'system_id', 'college_id', 'plan_id', 'course_id', 'semester_id', 'discipline_id',
        'lecture_hours', 'lab_hours', 'practical_hours', 'solo_hours', 'exam_hours', 'zet_hours', 'weeks_count',
        'control_type',
        ];

    public function discipline()
    {
        return $this->belongsTo(Discipline::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function getZetHoursAttribute($value)
    {
        return round($value, 1);
    }

    public function getWeeksCountAttribute($value)
    {
        return round($value, 1);
    }

    public function sum()
    {
        return $this->lecture_hours + $this->lab_hours + $this->practical_hours + $this->solo_hours + $this->exam_hours;
    }
}
