<?php

namespace App\Http\Controllers\Training;

use App\Models\Pulpit;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PulpitsController extends Controller
{
    public function index()
    {
        $items = Pulpit::where('college_id', $this->college->id)->where('system_id', $this->educationSystemId)->get();
        return view('training.pulpits.index', compact('items'));
    }

    public function create()
    {
        return view('training.pulpits.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['college_id'] = \Auth::user()->college_id;
        $data['system_id'] = $this->educationSystemId;
        Pulpit::create($data);
        return redirect('training/pulpits');
    }

    public function edit($id)
    {
        $item = Pulpit::find($id);
        if ($item->college_id != $this->college->id) {
            abort(404);
        }
        return view('training.pulpits.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = Pulpit::find($id);
        if ($item->college_id != $this->college->id) {
            abort(404);
        }
        $data = $request->all();
        $item->update($data);
        return redirect('training/pulpits');
    }

    public function destroy($id)
    {
        $item = Pulpit::find($id);
        if ($item->college_id != $this->college->id) {
            abort(404);
        }
        $item->delete();
        return redirect('training/pulpits');
    }
}
