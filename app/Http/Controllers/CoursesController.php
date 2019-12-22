<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

use App\Models\School;
use App\Models\Specialization;

class CoursesController extends Controller
{
    public function index()
    {
        $items = Course::where('college_id', $this->college->id)->where('system_id', $this->educationSystemId)
            ->get();
        return view('courses.index', compact('items'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['college_id'] = \Auth::user()->college_id;
        $data['system_id'] = $this->educationSystemId;
        Course::create($data);
        return redirect('dic/courses');
    }

    public function edit($id)
    {
        $item = Course::find($id);
        if ($item->college_id != $this->college->id) {
            abort(404);
        }
        return view('courses.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = Course::find($id);
        if ($item->college_id != $this->college->id) {
            abort(404);
        }
        $data = $request->all();
        $item->update($data);
        return redirect('dic/courses');
    }

    public function destroy($id)
    {
        $item = Course::find($id);
        if ($item->college_id != $this->college->id) {
            abort(404);
        }
        $item->delete();
        return redirect('dic/courses');
    }
}
