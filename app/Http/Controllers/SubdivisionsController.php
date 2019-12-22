<?php

namespace App\Http\Controllers;

use App\Models\Subdivision;

use Illuminate\Http\Request;

class SubdivisionsController extends Controller
{
    public function index()
    {
        $items = Subdivision::where('college_id', $this->college->id)->where('system_id', $this->educationSystemId)->get();
        return view('subdivisions.index', compact('items'));
    }

    public function create()
    {
        return view('subdivisions.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['system_id'] = $this->educationSystemId;
        Subdivision::create($data);
        return redirect('college/subdivisions');
    }

    public function edit($id)
    {
        $item = Subdivision::find($id);
        if ($item->college_id != $this->college->id) {
            abort(404);
        }

        return view('subdivisions.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = Subdivision::find($id);
        if ($item->college_id != $this->college->id) {
            abort(404);
        }

        $item->update($request->all());
        return redirect('college/subdivisions');
    }

    public function destroy($id)
    {
        $item = Subdivision::find($id);
        if ($item->college_id != $this->college->id) {
            abort(404);
        }

        $item->delete();
        return redirect('college/subdivisions');
    }
}
