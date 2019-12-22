<?php

namespace App\Http\Controllers\Training;

use App\Models\Hall;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class HallsController extends Controller
{
    public function index()
    {
        $items = Hall::where('college_id', $this->college->id)->where('system_id', $this->educationSystemId)->get();

        return view('training.halls.index', compact('items'));
    }

    public function create()
    {
        return view('training.halls.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['college_id'] = \Auth::user()->college_id;
        $data['system_id'] = $this->educationSystemId;
        $Hall = new Hall($data);
        $Hall->save();
        return redirect('training/halls');
    }

    public function edit($id)
    {
        $item = Hall::find($id);
        if ($item->college_id != $this->college->id) {
            abort(404);
        }
        return view('training.halls.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = Hall::find($id);
        if ($item->college_id != $this->college->id) {
            abort(404);
        }
        $data = $request->all();
        $item->update($data);
        return redirect('training/halls');
    }

    public function destroy($id)
    {
        $item = Hall::find($id);
        if ($item->college_id != $this->college->id) {
            abort(404);
        }
        $item->delete();
        return redirect('training/halls');
    }
}
