<?php

namespace App\Http\Controllers;

use App\Models\EnrollmentReason;
use Illuminate\Http\Request;

use App\Http\Requests;

class EnrollmentReasonsController extends Controller
{
    public function index()
    {
        $items = EnrollmentReason::where('college_id', $this->college->id)->where('system_id', $this->educationSystemId)
            ->orWhere('is_global', 1)->get();
        return view('enrollment-reasons.index', compact('items'));
    }

    public function create()
    {
        return view('enrollment-reasons.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['college_id'] = \Auth::user()->college_id;
        $data['system_id'] = $this->educationSystemId;
        EnrollmentReason::create($data);
        return redirect('dic/enrollment-reasons');
    }

    public function edit($id)
    {
        $item = EnrollmentReason::find($id);
        if ($item->college_id != $this->college->id) {
            abort(404);
        }
        return view('enrollment-reasons.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = EnrollmentReason::find($id);
        if ($item->college_id != $this->college->id) {
            abort(404);
        }
        $data = $request->all();
        $item->update($data);
        return redirect('dic/enrollment-reasons');
    }

    public function destroy($id)
    {
        $item = EnrollmentReason::find($id);
        if ($item->college_id != $this->college->id) {
            abort(404);
        }
        $item->delete();
        return redirect('dic/enrollment-reasons');
    }
}
