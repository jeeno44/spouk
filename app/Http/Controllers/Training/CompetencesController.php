<?php

namespace App\Http\Controllers\Training;

use App\Models\Competence;
use App\Models\Discipline;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CompetencesController extends Controller
{
    public function index()
    {
        $items = Competence::where('college_id', $this->college->id)->where('system_id', $this->educationSystemId)->get();
        return view('training.competences.index', compact('items'));
    }

    public function create()
    {
        $disciplines = Discipline::where('college_id', $this->college->id)->where('system_id', $this->educationSystemId)->get();
        return view('training.competences.create', compact('disciplines'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['college_id'] = \Auth::user()->college_id;
        $data['system_id'] = $this->educationSystemId;
        $item = new Competence($data);
        $item->save();
        if ($request->has('disciplines')) {
            foreach ($request->get('disciplines') as $d) {
                $item->disciplines()->attach($d);
            }
        }
        return redirect('training/competences');
    }

    public function show($id)
    {
        $item = Competence::find($id);
        if ($item->college_id != $this->college->id) {
            abort(404);
        }
        return view('training.competences.show', compact('item'));
    }

    public function edit($id)
    {
        $item = Competence::find($id);
        $disciplines = Discipline::where('college_id', $this->college->id)->where('system_id', $this->educationSystemId)->get();
        if ($item->college_id != $this->college->id) {
            abort(404);
        }
        return view('training.competences.edit', compact('item', 'disciplines'));
    }

    public function update(Request $request, $id)
    {
        $item = Competence::find($id);
        if ($item->college_id != $this->college->id) {
            abort(404);
        }
        $data = $request->all();
        $item->update($data);
        \DB::table('discipline_competence')->where('competence_id', $item->id)->delete();
        if ($request->has('disciplines')) {
            foreach ($request->get('disciplines') as $d) {
                $item->disciplines()->attach($d);
            }
        }
        return redirect('training/competences');
    }

    public function destroy($id)
    {
        $item = Competence::find($id);
        if ($item->college_id != $this->college->id) {
            abort(404);
        }
        $item->delete();
        return redirect('training/competences');
    }
}
