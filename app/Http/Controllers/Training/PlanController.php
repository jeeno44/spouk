<?php

namespace App\Http\Controllers\Training;

use App\Models\Plan;
use App\Models\PlanDiscipline;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Discipline;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PlanController extends Controller
{
    public function __construct()
    {
        $this->scripts[] = '/assets/js/training.js';
        parent::__construct();
    }

    public function index()
    {
        $items = Plan::where('college_id', $this->college->id)->where('system_id', $this->educationSystemId)->latest()->get();
        return view('training.plans.index', compact('items'));
    }

    public function create()
    {
        return view('training.plans.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['college_id'] = \Auth::user()->college_id;
        $data['system_id'] = $this->educationSystemId;
        Plan::create($data);
        return redirect('training/plans');
    }

    public function show($id)
    {
        $item = Plan::find($id);
        $courses = Course::where('college_id', $this->college->id)->where('system_id', $this->educationSystemId)
            ->get();
        $items = PlanDiscipline::where([
            'plan_id'       => $id,
        ])->get();
        return view('training.plans.show', compact('item', 'courses', 'items'));
    }

    public function edit($id)
    {
        $item = Plan::find($id);
        if ($item->college_id != $this->college->id) {
            abort(404);
        }
        return view('training.plans.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = Plan::find($id);
        if ($item->college_id != $this->college->id) {
            abort(404);
        }
        $data = $request->all();
        $item->update($data);
        return redirect('training/plans');
    }

    public function destroy($id)
    {
        $item = Plan::find($id);
        if ($item->college_id != $this->college->id) {
            abort(404);
        }
        $item->delete();
        return redirect('training/plans');
    }

    public function disciplines($planId, $courseId, $semesterId)
    {
        $items = PlanDiscipline::where([
            'plan_id'       => $planId,
            'course_id'     => $courseId,
            'semester_id'   => $semesterId,
        ])->get();
        $disciplines = Discipline::where('college_id', $this->college->id)->where('system_id', $this->educationSystemId)
            ->pluck('title', 'id')->toArray();
        return view('training.plans.disciplines.edit', compact('items', 'disciplines'));
    }

    public function disciplinesStore($planId, $courseId, $semesterId, Request $request)
    {
        PlanDiscipline::where([
            'plan_id'       => $planId,
            'course_id'     => $courseId,
            'semester_id'   => $semesterId,
        ])->delete();
        $dics = $request->get('disciplines');
        $lecture = $request->get('lecture');
        $lab = $request->get('lab');
        $practical = $request->get('practical');
        $solo = $request->get('solo');
        $exam = $request->get('exam');
        $zet = $request->get('zet');
        $weeks = $request->get('weeks');
        $controls = $request->get('controls');
        foreach ($dics as $key => $val) {
            PlanDiscipline::create([
                'system_id'         => $this->educationSystemId,
                'college_id'        => $this->college->id,
                'plan_id'           => $planId,
                'course_id'         => $courseId,
                'semester_id'       => $semesterId,
                'discipline_id'     => $val,
                'lecture_hours'     => $lecture[$key],
                'lab_hours'         => $lab[$key],
                'practical_hours'   => $practical[$key],
                'solo_hours'        => $solo[$key],
                'exam_hours'        => $exam[$key],
                'zet_hours'         => $zet[$key],
                'weeks_count'       => $weeks[$key],
                'control_type'      => $controls[$key],
            ]);
        }
        return redirect('/training/plans/' . $planId);
    }

    public function disciplinesLoadForm()
    {
        $disciplines = Discipline::where('college_id', $this->college->id)->where('system_id', $this->educationSystemId)
            ->pluck('title', 'id')->toArray();
        return view('training.plans.disciplines.form', compact('disciplines'));
    }
}
