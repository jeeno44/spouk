<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\College;
use App\Models\Region;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class ApiController extends Controller
{
    public function collegesAutocomplete(Request $request)
    {
        if (!empty($request->get('city_id')) && !empty($request->get('region_id'))) {
            $colleges = College::where('city_id', $request->get('city_id'))
                ->where('title', 'like', '%'.$request->get('term').'%')
                ->with('region', 'city')->take(20)->get();
        } elseif (!empty($request->get('region_id'))) {
            $colleges = College::where('region_id', $request->get('region_id'))
                ->where('title', 'like', '%'.$request->get('term').'%')
                ->with('region', 'city')->take(20)->get();
        } else {
            $colleges = College::where('title', 'like', '%'.$request->get('term').'%')
                ->with('region', 'city')->take(20)->get();
        }
        $answer = [];
        foreach ($colleges as $college) {
            $answer[] = [
                'id'            => $college->id,
                'key'           => $college->id,
                'value'         => $college->title,
                'region'        => $college->region_id,
                'region_name'   => $college->region->title,
                'city'          => $college->city_id,
                'city_name'     => $college->city->title,
            ];
        }
        return \Response::json($answer, 200, ['Content-Type: text/html; charset=utf-8']);
    }
        
    /**
     * Автозаполнения школ
     * 
     * @param  Requests $request
     * @return string [JSON]
     * @access public
     */
    
    public function schoolsAutocomplete(Request $request)
    {
        if ( !$request->get('term') )
            return '[]';
        
        $schools = School::where('region_id', $request->get('region_id'))->where('city_id', $request->get('city_id'))
                         ->where('title', 'like', '%'.$request->get('term').'%')->orderBy('title')->take(20)->get();

        $response = array();
        foreach ( $schools as $school )
        {
            $response[] = [
              'id'      => $school->id,
              'title'   => $school->title,
              'key'     => $school->id,
              'value'   => $school->title,
            ];
        }
        
        return \Response::json($response, 200, ['Content-Type: text/html; charset=utf-8']);
    }
    
    /**
     * Автокомплит по фамилии
     * 
     * @param  Request $request
     * @return string [JSON]
     * @access public
     */
    
    public function autoCompleteFamily(Request $request)
    {
        $last_names = \App\Models\Candidate::where('last_name', 'like', '%'.$request->get('term').'%')
            ->orderBy('last_name')
            ->groupBy('last_name')
            ->take(10)->get();
        
        $response = array();
        foreach ( $last_names as $last_name )
        {
            $response[] = [
              'key'     => $last_name->id,
              'value'   => $last_name->last_name,
            ];
        }
        
        return \Response::json($response, 200, ['Content-Type: text/html; charset=utf-8']);
    }
    
    /**
     * Автокомплит по имени
     * 
     * @param  Request $request
     * @return string [JSON]
     * @access public
     */
    
    public function autoCompleteName(Request $request)
    {
        $last_names = \App\Models\Candidate::where('first_name', 'like', '%'.$request->get('term').'%')
            ->groupBy('first_name')->orderBy('first_name')->take(10)->get();
        
        $response = array();
        foreach ( $last_names as $last_name )
        {
            $response[] = [
              'key'     => $last_name->id,
              'value'   => $last_name->first_name,
            ];
        }
        
        return \Response::json($response, 200, ['Content-Type: text/html; charset=utf-8']);
    }
    
    /**
     * Автокомплит по отчеству
     * 
     * @param  Request $request
     * @return string [JSON]
     * @access public
     */
    
    public function autoCompleteMiddleName(Request $request)
    {
        $last_names = \App\Models\Candidate::where('middle_name', 'like', '%'.$request->get('term').'%')
            ->groupBy('middle_name')->orderBy('middle_name')->take(10)->get();
        
        $response = array();
        foreach ( $last_names as $last_name )
        {
            $response[] = [
              'key'     => $last_name->id,
              'value'   => $last_name->middle_name,
            ];
        }
        
        return \Response::json($response, 200, ['Content-Type: text/html; charset=utf-8']);
    }    
    
    /**
     * Получаем города нужного региона
     * 
     * @param  Request $request
     * @return string [JSON]
     * @access public
     */
    
    public function getCities(Request $request)
    {       
        return \Response::json(array('cities' => City::where('region_id', $request->get('region_id'))->lists('title', 'id')), 200, ['Content-Type: text/html; charset=utf-8']);
    }

    public function citiesAutocomplete(Request $request)
    {
        if (!empty($request->get('region_id'))) {
            $cities = City::where('region_id', $request->get('region_id'))
                ->where('title', 'like', '%'.$request->get('term').'%')
                ->with('region')->take(20)->get();
        } else {
            $cities = City::where('title', 'like', '%'.$request->get('term').'%')
                ->with('region')->take(20)->get();
        }
        $answer = [];
        foreach ($cities as $city) {
            $answer[] = [
                'id'            => $city->id,
                'key'           => $city->id,
                'value'         => $city->title,
                'region'        => $city->region_id,
                'region_name'   => $city->region->title,
            ];
        }
        return \Response::json($answer, 200, ['Content-Type: text/html; charset=utf-8']);
    }

    public function regionsAutocomplete(Request $request)
    {
        $regions = Region::where('title', 'like', '%'.$request->get('term').'%')
            ->take(20)->get();
        $answer = [];
        foreach ($regions as $city) {
            $answer[] = [
                'id'            => $city->id,
                'key'           => $city->id,
                'value'         => $city->title,
            ];
        }
        return \Response::json($answer, 200, ['Content-Type: text/html; charset=utf-8']);
    }

    public function commission($id)
    {
        $user = User::find($id);
        if ($user->college_id == \Auth::user()->college_id) {
            $user->is_commission = abs($user->is_commission - 1);
            $user->save();
        }
    }

    public function specs(Request $request)
    {
        if (!empty($request->get('subID'))) {
            $specs = \App\Models\Specialization::where('college_id', \Auth::user()->college_id)
                ->where('system_id', $this->educationSystemId)
                ->where('subdivision_id', $request->get('subID'))
                ->orderBy('title')
                ->orderBy('code')
                ->get();
        } else {
            $specs = \App\Models\Specialization::where('college_id', \Auth::user()->college_id)
                ->where('system_id', $this->educationSystemId)
                ->orderBy('title')
                ->orderBy('code')
                ->get();
        }
        $out = [];
        foreach ($specs as $s) {
            $out[$s->id] = $s->title;
        }
        return view('api.specs', compact('out'));
    }

    public function subdivs(Request $request)
    {
        $specs = \App\Models\Subdivision::where('college_id', \Auth::user()->college_id)
            ->where('system_id', $this->educationSystemId)
            ->where('title', 'like', '%'.$request->get('term').'%')
            ->orderBy('title')
            ->orderBy('code')
            ->get();
        $out = [];
        foreach ($specs as $s) {
            $out[] = [
                'value' => $s->title,
                'id' => $s->id,
                'key' => $s->id
            ];
        }
        return \Response::json($out);
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('files')) {
            $path = str_random().'.'.$request->file('files')->getClientOriginalExtension();
            $name = $request->file('files')->getClientOriginalName();
            $type = $request->file('files')->getClientOriginalExtension();
            $size = $request->file('files')->getClientSize();
            $request->file('files')->move(base_path('docs/tmp'), $path);
            return view('api.upload', compact('name', 'path', 'type', 'size'));
        }
    }

    public function removeFile(Request $request)
    {
        $path = $request->get('path');
        if (!empty($path)) {
            \File::delete(base_path('docs/tmp/'.$path));
            \DB::table('candidates_docs')->where('college_id', \Auth::user()->college_id)->where('filename', $path)->delete();
        }
    }

    function getGroups($specID)
    {
        $groups = getFilterGroups(\Auth::user()->college_id, $specID);
        foreach ($groups as $id => $group) {
            echo '<option value="'.$id.'">'.$group.'</option>';
        }
    }
}
