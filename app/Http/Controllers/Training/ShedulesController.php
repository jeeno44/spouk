<?php

namespace App\Http\Controllers\Training;

use App\Models\Course;
use App\Models\Discipline;
use App\Models\Hall;
use App\Models\HourType;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Sked;
use Illuminate\Support\Facades\Input;

class ShedulesController extends Controller
{
    public function __construct()
    {
        $this->scripts[]='/assets/js/skeds.js';
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$items = Plan::where('college_id', $this->college->id)->where('system_id', $this->educationSystemId)->latest()->get();
        //$items=[''];
        return view('training.shedules.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=$request->all();
        $data['college_id']=\Auth::user()->college_id;
        $data['system_id']=$this->educationSystemId;
        Sked::create($data);
        return redirect()->back();
    }

    public function show($id)
    {

    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {

    }

    public function ajax()
    {
        if(Input::get('send')==1){
            $date=Input::get('date');
            $discipline=Input::get('discipline');
            $courses=Input::get('courses');
            $type_job=HourType::find(Input::get('type_job'))->title;
            $hall=(Input::get('five')=='' ? '' : Input::get('five'));

            $sked=new Sked();
            $sked->college_id = \Auth::user()->college_id;
            $sked->system_id = $this->educationSystemId;
            $sked->date = $date;
            $sked->length = '';
            $sked->hall_id = $hall;
            $sked->discipline_id = $discipline;
            $sked->course_id = $courses;
            $sked->hour_type_id = $type_job;
            $sked->semester_id = rand(1,2);
            $sked->save();


            $data=[];
            foreach (Sked::where('college_id',\Auth::user()->college_id)->where('system_id',$this->educationSystemId)->get() as $arr) {
                $data[]=['id'=>$arr->id,'title'=>$arr->discipline->title,'start'=>$arr->date];
            }
            return $data;
        }


        $data=[];

        foreach (Sked::where('college_id',\Auth::user()->college_id)->where('system_id',$this->educationSystemId)->get() as $arr) {
           $data[]=['id'=>$arr->id,'title'=>$arr->discipline->title,'start'=>$arr->date];
        }

        //dd($data);
        return $data;
    }

    public function ajax_delite()
    {
        if(Input::get('delite')==1){
            $del=Sked::destroy(Input::get('id'));
            echo "Delite id - ".Input::get('id');
        }
    }

}
