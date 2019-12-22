<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Specialization;

class SpecializationsController extends Controller
{
    public function index()
    {
        $items = Specialization::where('college_id', $this->college->id)
            ->where('system_id', $this->educationSystemId)
            ->orWhere('is_global', 1)->where('system_id', $this->educationSystemId)
            ->get();
        return view('specializations.index', compact('items'));
    }

    public function create()
    {
        return view('specializations.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        if (empty($data['subdivision_id'])) {
            $data['subdivision_id'] = null;
        }
        $data['system_id'] = $this->educationSystemId;

        Specialization::create($data);
        return redirect('dic/specializations');
    }

    public function edit($id)
    {
        $item = Specialization::find($id);
        if ($item->college_id != $this->college->id) {
            abort(404);
        }

        return view('specializations.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = Specialization::find($id);
        if ($item->college_id != $this->college->id) {
            abort(404);
        }

        $data = $request->all();
        if (empty($data['subdivision_id'])) {
            $data['subdivision_id'] = null;
        }

        $item->update($data);
        return redirect('dic/specializations');
    }

    public function destroy($id)
    {
        $item = Specialization::find($id);
        if ($item->college_id != $this->college->id) {
            abort(404);
        }

        $item->delete();

        return redirect('dic/specializations');
    }
}
