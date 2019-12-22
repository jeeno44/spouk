<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Candidate extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'first_name','last_name','college_id','middle_name','birth_date','email','rate','is_invalid', 'gpa',
        'education_id','certificate','region_id','city_id','school_id','graduatedClass','graduatedYear','admissionYear','address',
        'gender', 'certificate_provided', 'certificate_issued_at', 'passport_number', 'passport_provided_place', 'passport_provided_at', 'passport_place_code',
        'law_address', 'medical_number', 'medical_provided_place', 'medical_provided_at', 'pension_certificate', 'photos_provided',
        'vaccinations_provided', 'health_certificate_provided', 'certificate_25u_provided', 'form_training', 'monetary_basis', 'specialization_id',
        'fatherless', 'date_of_filing', 'date_took', 'reg_number', 'subdivision_id', 'is_invalid1', 'protocol_id', 'group_id', 'is_student',
        'is_russian', 'international_passport', 'system_id', 'expelled', 'final', 'name_number', 'inflow'
    ];

    public function specializations()
    {
        return $this->belongsToMany('App\Models\Specialization', 'specializations_candidates', 'candidate_id', 'specialization_id');
    }
    
    public function spec()
    {
        return $this->belongsTo('App\Models\Specialization', 'specialization_id');
    }

    public function group()
    {
        return $this->belongsTo('App\Models\SpecializationGroup', 'group_id');
    }

    public function protocol()
    {
        return $this->belongsTo('App\Models\Protocol', 'protocol_id')->where('type', 'protocol');
    }

    public function order()
    {
        return $this->belongsTo('App\Models\Protocol', 'protocol_id')->where('type', 'order');
    }
    
    public function formTraining()
    {
        return $this->belongsTo('App\Models\FormTraining', 'form_training', 'id');
    }
    
    public function monetaryBasis()
    {
        return $this->belongsTo('App\Models\MonetaryBasis', 'monetary_basis', 'id');
    }

    public function docs()
    {
        return $this->hasMany('App\Models\CandidateDoc', 'candidate_id');
    }

    public function parents()
    {
        return $this->hasMany('App\Models\CandidateParent', 'candidate_id');
    }
    
    public function phones()
    {
        return $this->hasMany('App\Models\CandidatesPhones', 'candidate_id');
    }

    public function educationType()
    {
        return $this->belongsTo('App\Models\EducationType', 'education_id');
    }

    public function school()
    {
        return $this->belongsTo('App\Models\School', 'school_id');
    }

    public function region()
    {
        return $this->belongsTo('App\Models\Region');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    /*
     * Возвращает группы в которых есть студенты
     */
    static public function getGroupStudents()
	{
		return DB::table('specializations_groups')
            ->join('candidates', 'candidates.group_id', '=', 'specializations_groups.id')
            ->select('specializations_groups.id', 'specializations_groups.title')
            ->where(['candidates.is_student' => 1, 'candidates.college_id' => \Auth::user()->college_id])
            ->where('candidates.system_id', \Session::get('educationSystemId'))
            ->distinct()
            ->get();
	}

	static public function getGroupRecruits()
    {
        return DB::table('specializations_groups')
            ->join('candidates', 'candidates.group_id', '=', 'specializations_groups.id')
            ->select('specializations_groups.id', 'specializations_groups.title')
            ->where(['candidates.is_student' => 1, 'candidates.college_id' => \Auth::user()->college_id])
            ->where('candidates.system_id', \Session::get('educationSystemId'))
            ->where(DB::raw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE())'), '<', 18)
            ->distinct()
            ->get();
    }

	/*
	 * Возвращает список студентов по заданной группе
	 */
	static public function getStudentsOfGroup($group_id)
	{
		return self::where('group_id', $group_id)
               ->orderBy('last_name', 'desc')
               ->get();
	}

    public function orders() {
        return $this->belongsToMany(Order::class, 'candidate_order');
    }
}
