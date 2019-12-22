<?php

if (!function_exists('widget')) {

    function widget($class, $params = null)
    {
        return app('App\Widgets\\'.$class)->run();
    }
}

function ruDate($date){
    $timestamp = strtotime($date);
    $d = date('d', $timestamp);
    $y = date('Y', $timestamp);
    $m = date('m', $timestamp);
    switch($m) {
        case '01': $m = 'января'; break;
        case '02': $m = 'февраля'; break;
        case '03': $m = 'марта'; break;
        case '04': $m = 'апреля'; break;
        case '05': $m = 'мая'; break;
        case '06': $m = 'июня'; break;
        case '07': $m = 'июля'; break;
        case '08': $m = 'августа'; break;
        case '09': $m = 'сентября'; break;
        case '10': $m = 'октября'; break;
        case '11': $m = 'ноября'; break;
        default: $m = 'декабря';
    }
    return "{$d} {$m} {$y}";
}

function ruDateMonth($timestamp){
    $d = date('d', $timestamp);
    $y = date('Y', $timestamp);
    $m = date('m', $timestamp);
    switch($m) {
        case '01': $m = 'января'; break;
        case '02': $m = 'февраля'; break;
        case '03': $m = 'марта'; break;
        case '04': $m = 'апреля'; break;
        case '05': $m = 'мая'; break;
        case '06': $m = 'июня'; break;
        case '07': $m = 'июля'; break;
        case '08': $m = 'августа'; break;
        case '09': $m = 'сентября'; break;
        case '10': $m = 'октября'; break;
        case '11': $m = 'ноября'; break;
        default: $m = 'декабря';
    }
    return "{$d} {$m}";
}

function isJSON($string){
    return is_string($string) && is_array(json_decode($string, true)) ? true : false;
}

function my_mb_ucfirst($str) {
    $fc = mb_strtoupper(mb_substr($str, 0, 1));
    return $fc.mb_substr($str, 1);
}

function getSpecializations($collegeID, $specID = null) {
    if (!$specID) {
        $specs[''] = 'Не выбрана';
        $specsDb = \App\Models\Specialization::where('college_id', $collegeID)
            ->where('system_id', \Session::get('educationSystemId'))
            ->orWhere('is_global', 1)->where('system_id',  \Session::get('educationSystemId'))
            ->lists('title', 'id')->toArray();
        foreach ($specsDb as $id => $spec) {
            $specs[$id] = $spec;
        }
        return $specs;
    } else {
        $spec = \App\Models\Specialization::find($specID);
        return !empty($spec->title) ? $spec->title : '';
    }
}

function getFilterGroups($collegeID, $specID = null) {
    if (!$specID) {
        $specs[''] = 'Не выбрана';
        $specsDb = \App\Models\Specialization::where('college_id', $collegeID)
            ->where('system_id', \Session::get('educationSystemId'))
            ->orWhere('is_global', 1)->where('system_id',  \Session::get('educationSystemId'))
            ->lists('id')->toArray();
        $groups = \App\Models\SpecializationGroup::whereIn('specialization_id', $specsDb)->where('final', 0)->get();
        foreach ($groups as $group) {
            $specs[$group->id] = $group->title;
        }
        return $specs;
    } else {
        $specs[''] = 'Не выбрана';
        $groups = \App\Models\SpecializationGroup::where('specialization_id', $specID)->where('final', 0)->get();
        foreach ($groups as $group) {
            $specs[$group->id] = $group->title;
        }
        return $specs;
    }
}

function getFormTrainings() {
    $specsDb = \App\Models\FormTraining::all();
    foreach ($specsDb as $spec) {
        $specs[$spec->id] = $spec->title;
    }
    return $specs;
}

function getMonetaryBasis() {
    $specs[''] = 'Не выбрана';
    $specsDb = \App\Models\MonetaryBasis::all();
    foreach ($specsDb as $spec) {
        $specs[$spec->id] = $spec->title;
    }
    return $specs;
}

function getEducationTypes() {
    $specs[''] = 'Не выбран';
    $specsDb = \App\Models\EducationType::all();
    foreach ($specsDb as $spec) {
        $specs[$spec->id] = $spec->title;
    }
    return $specs;
}

function getSubdivisions($collegeID, $specID = null) {
    if (!$specID) {
        $specs[''] = 'Не выбрано';
        $specsDb = \App\Models\Subdivision::where('college_id', $collegeID)
            ->where('system_id', \Session::get('educationSystemId'))
            ->lists('title', 'id')->toArray();
        foreach ($specsDb as $id => $spec) {
            $specs[$id] = $spec;
        }
        return $specs;
    } else {
        $spec = \App\Models\Subdivision::find($specID);
        return !empty($spec->title) ? $spec->title : '';
    }
}

function getSpecialCandidates($collegeID)
{
    $specsDb = \App\Models\Specialization::where('college_id', $collegeID)
        ->where('system_id', \Session::get('educationSystemId'))
        ->lists('title', 'id')->toArray();
    $specs = [];
    foreach ($specsDb as $id => $spec) {
        $specs[$id] = $spec;
    }
    return $specs;
}

function getRegions()
{
    $regions  = array();
    $_regions = \App\Models\Region::orderBy('title')->lists('title', 'id')->toArray();
    
    foreach ( $_regions as $regionID => $title )
        $regions[$regionID] = $title;
    
    return $regions;
}

function getCitys($regionID)
{
    $citys  = array();
    $_citys = \App\Models\City::where('region_id', $regionID)->orderBy('title')->lists('title', 'id')->toArray();
    
    foreach ( $_citys as $cityID => $title )
        $citys[$cityID] = $title;
    
    return $citys;
}

function getEducationsTypes()
{
    return \App\Models\EducationType::orderBy('id')->lists('title', 'id')->toArray();
}

function getGroups($collegeID, $groupID = null) {
    if (!$groupID) {
        $groups[''] = 'Не выбрана';
        $specsDb = \App\Models\SpecializationGroup::leftJoin('specializations', 'specializations.id', '=', 'specializations_groups.specialization_id')
            ->where('specializations.college_id', $collegeID)
            ->where('specializations_groups.final', 0)
            ->where('specializations.system_id', \Session::get('educationSystemId'))
            ->select('specializations_groups.*')->lists('title', 'id')->toArray();
        foreach ($specsDb as $id => $spec) {
            $groups[$id] = $spec;
        }
        return $groups;
    } else {
        $group = \App\Models\SpecializationGroup::find($groupID);
        return !empty($group->title) ? $group->title : '';
    }
}

function getGroupsSpec($collegeID, $specID)
{
    $groups[''] = 'Выберите группу';
        $specsDb = \App\Models\SpecializationGroup::leftJoin('specializations', 'specializations.id', '=', 'specializations_groups.specialization_id')
            ->where('specializations.college_id', $collegeID)
            ->where('specializations_groups.final', 0)
            ->where('specializations.system_id', \Session::get('educationSystemId'))
            ->where('specializations_groups.specialization_id', $specID)
            ->select('specializations_groups.*')->lists('title', 'id')->toArray();
        foreach ($specsDb as $id => $spec) {
            $groups[$id] = $spec;
        }
        return $groups;
}

function getParentType($type) {
    $items = ['mom' => 'Мать', 'dad' => 'Отец', 'other' => 'Законный представитель'];
    if (!empty($items[$type])) {
        return $items[$type];
    }
    return '';
}

function age($birthday) {
    $birthday_timestamp = strtotime($birthday);
    $age = date('Y') - date('Y', $birthday_timestamp);
    if (date('md', $birthday_timestamp) > date('md')) {
        $age--;
    }
    return $age;
}


function datetime($format, $datatime = NULL)
{
	if ($datatime == NULL)
	{
		return date($format);
	}

	return date($format, strtotime($datatime));
}

function getFile($path) {

}

function toNum($key) {
    $alphabet = array('', 'a', 'b', 'c', 'd', 'e',
        'f', 'g', 'h', 'i', 'j',
        'k', 'l', 'm', 'n', 'o',
        'p', 'q', 'r', 's', 't',
        'u', 'v', 'w', 'x', 'y',
        'z'
    );
    return strtoupper($alphabet[$key]);
}

function disciplines($systemId)
{
    return \App\Models\Discipline::where('college_id',Auth::user()->college_id)->where('system_id',$systemId)->pluck('title','id')->toArray();
}

function courses($systemId)
{
    return \App\Models\Course::where('college_id',Auth::user()->college_id)->where('system_id',$systemId)->pluck('title','id')->toArray();
}

function hourTypes()
{
    return \App\Models\HourType::pluck('title','id')->toArray();
}

function halls($systemId)
{
    $data = [
        '' => 'Не выбрана'
    ];

    foreach (\App\Models\Hall::where('college_id', Auth::user()->college_id)->where('system_id', $systemId)->get() as $hall) {

        $data[$hall->id] = $hall->title;
    }

    return $data;
}

