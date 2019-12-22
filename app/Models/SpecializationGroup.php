<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecializationGroup extends Model
{
    protected $table = 'specializations_groups';

    protected $fillable = ['title', 'year', 'code', 'teacher_id', 'specialization_id', 'semester_id', 'course_id',
    					   'number_course',	'non_free_places', 'free_places', 'final', 'faculty_id'];

    public function specialization()
    {
        return $this->belongsTo('App\Models\Specialization', 'specialization_id');
    }

    public function teacher()
    {
        return $this->belongsTo('App\Models\User', 'teacher_id');
    }

    public function course()
    {
        return $this->belongsTo('App\Models\Course', 'course_id');
    }

    public function candidates()
    {
        return $this->hasMany(Candidate::class, 'group_id');
    }

    public function students()
    {
        return $this->candidates()->where('is_student', 1)->where('expelled', 0)->where('final', 0)->orderBy('last_name')->get();
    }

    static public function getNextSemester($course)
	{
		return \DB::select(static::sqlNextSemester(' and c.value = '.$course));
	}

	static public function getAllNextSemester()
	{
		return \DB::select(static::sqlNextSemester());
	}

	static private function sqlNextSemester($filter = '')
	{
		return 'select g.id, g.title from spo_specializations_groups g 
						 join spo_specializations z on z.id = g.specialization_id
						 join spo_dictionaries s on s.id = g.semester_id
						 join spo_dictionaries c on c.id = g.course_id
						 where z.college_id = '.\Auth::user()->college_id.' and s.value = 1 '.$filter.' 
						 order by g.title';
	}


	static public function getNextCourse($course)
	{
		return \DB::select(static::sqlNextCourse(' and c.value = '.$course));
	}
	static public function getAllNextCourse()
	{
		return \DB::select(static::sqlNextCourse());
	}
	static private function sqlNextCourse($filter = '')
	{
		return 'select g.id, g.title from spo_specializations_groups g 
						 join spo_specializations z on z.id = g.specialization_id
						 join spo_dictionaries s on s.id = g.semester_id
						 join spo_dictionaries c on c.id = g.course_id
						 where z.college_id = '.\Auth::user()->college_id.' and s.value = 2 and g.number_course < c.value '.$filter.' 
						 order by g.title';
	}

	static public function getOutCourse($course)
	{
		return \DB::select(static::sqlOutCourse(' and c.value = '.$course));
	}

	static public function getAllOutCourse()
	{
		return \DB::select(static::sqlOutCourse());
	}

	static private function sqlOutCourse($filter = '')
	{
		return 'select g.id, g.title from spo_specializations_groups g 
						 join spo_specializations z on z.id = g.specialization_id
						 join spo_dictionaries s on s.id = g.semester_id
						 join spo_dictionaries c on c.id = g.course_id
						 where z.college_id = '.\Auth::user()->college_id.' and s.value = 2 and g.number_course = c.value '.$filter.' 
						 order by g.title';
	}
}
