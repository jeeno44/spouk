<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\School;
use App\Models\Specialization;

class SchoolsController extends Controller
{
    public function index()
    {
        $items = School::where('college_id', $this->college->id)->where('system_id', $this->educationSystemId)
            ->orWhere('is_global', 1)->get();
        return view('schools.index', compact('items'));
    }

    public function create()
    {
        return view('schools.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['region_id'] = \Auth::user()->college->region_id;
        $data['city_id'] = \Auth::user()->college->city_id;
        $data['college_id'] = \Auth::user()->college_id;
        $data['system_id'] = $this->educationSystemId;
        School::create($data);
        return redirect('dic/schools');
    }

    public function edit($id)
    {
        $item = School::find($id);
        if ($item->college_id != $this->college->id) {
            abort(404);
        }
        return view('schools.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = School::find($id);
        if ($item->college_id != $this->college->id) {
            abort(404);
        }
        $data = $request->all();
        $item->update($data);
        return redirect('dic/schools');
    }

    public function destroy($id)
    {
        $item = School::find($id);
        if ($item->college_id != $this->college->id) {
            abort(404);
        }
        $item->delete();
        return redirect('dic/schools');
    }
}
