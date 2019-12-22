<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use Illuminate\Http\Request;

use App\Http\Requests;

class FacultiesController extends Controller
{
    public function index()
    {
        $items = Faculty::where('college_id', $this->college->id)->get();
        return view('faculties.index', compact('items'));
    }

    public function create()
    {
        return view('faculties.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['college_id'] = \Auth::user()->college_id;
        Faculty::create($data);
        return redirect('dec/faculties');
    }

    public function edit($id)
    {
        $item = Faculty::find($id);
        if ($item->college_id != $this->college->id) {
            abort(404);
        }
        return view('faculties.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = Faculty::find($id);
        if ($item->college_id != $this->college->id) {
            abort(404);
        }
        $data = $request->all();
        $item->update($data);
        return redirect('dec/faculties');
    }

    public function destroy($id)
    {
        $item = Faculty::find($id);
        if ($item->college_id != $this->college->id) {
            abort(404);
        }
        $item->delete();
        return redirect('dec/faculties');
    }
}
