<?php

namespace App\Http\Controllers\Training;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Sked;

class SchedulesController extends Controller
{
    public function __construct()
    {
        $this->styles[] = 'http://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.css';
        $this->styles[] = '/assets/css/skeds.css';
        $this->scripts[] = 'http://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js';
        $this->scripts[] = 'https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/locale/ru.js';
        $this->scripts[] = '/assets/js/skeds.js';
        parent::__construct();
    }

    public function index()
    {
        return view('training.schedules.index');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['college_id'] = \Auth::user()->college_id;
        $data['system_id'] = $this->educationSystemId;
        Sked::create($data);
    }

    public function drop($id, Request $request)
    {
        $sked = Sked::find($id);
        $sked->date = $request->get('date');
        $sked->save();
    }

    public function show($id)
    {
        $sked = Sked::find($id);
        return \Response::json([
            'id'                => $sked->id,
            'date'              => date('d.m.Y H:i', strtotime($sked->date)),
            'hall_id'           => (!empty($sked->hall_id) ? $sked->hall_id : ''),
            'discipline_id'     => $sked->discipline_id,
            'hour_type_id'      => $sked->hour_type_id,
            'semester_id'       => $sked->semester_id,
            'course_id'         => $sked->course->id,
        ]);
    }

    public function update(Request $request)
    {
        $sked = Sked::find($request->get('id'));
        if ($sked) {
            $sked->update($request->all());
        }
    }

    public function destroy($id)
    {
        $sked = Sked::find($id);
        if ($sked) {
            $sked->delete();
        }
    }

    public function ajax()
    {
        $data = [];
        foreach (Sked::where('college_id', \Auth::user()->college_id)->where('system_id', $this->educationSystemId)->get() as $sked) {
           $data[] = ['id' => $sked->id, 'title' => $sked->discipline->title, 'start' => $sked->date, 'cc' => 'ff'];
        }
        return $data;
    }


}
