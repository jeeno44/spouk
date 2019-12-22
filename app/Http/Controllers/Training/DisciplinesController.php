<?php

namespace App\Http\Controllers\Training;

use App\Models\Discipline;
use App\Models\Hall;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Pulpit;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DisciplinesController extends Controller
{
    public function index()
    {
        $items = Discipline::where('college_id', $this->college->id)->where('system_id', $this->educationSystemId)->get();
        return view('training.disciplines.index', compact('items'));
    }

    public function create()
    {
        $teachers = User::join('access_level_user', 'users.id', '=', 'access_level_user.user_id')
            ->where('users.college_id', $this->college->id)
            ->where('access_level_user.access_level_id', 2)
            ->select(\DB::raw('CONCAT(last_name, " ", first_name, " ", middle_name) AS fio, id'))
            ->get();
        $pulpits = Pulpit::where('college_id', $this->college->id)->where('system_id', $this->educationSystemId)->pluck('title', 'id')->toArray();
        $halls = Hall::where('college_id', $this->college->id)->where('system_id', $this->educationSystemId)->pluck('title', 'id')->toArray();
        return view('training.disciplines.create', compact('pulpits', 'teachers', 'halls'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['college_id'] = \Auth::user()->college_id;
        $data['system_id'] = $this->educationSystemId;
        //dd($data);
        $discipline = new Discipline($data);
        $discipline->save();
        if ($request->has('teachers')) {
            foreach ($request->get('teachers') as $t) {
                $discipline->users()->attach($t);
            }
        }
        return redirect('training/disciplines');
    }

    public function edit($id)
    {
        $item = Discipline::find($id);
        $teachers = User::join('access_level_user', 'users.id', '=', 'access_level_user.user_id')
            ->where('users.college_id', $this->college->id)
            ->where('access_level_user.access_level_id', 2)
            ->select(\DB::raw('CONCAT(last_name, " ", first_name, " ", middle_name) AS fio, id'))
            ->get();
        $pulpits = Pulpit::where('college_id', $this->college->id)->where('system_id', $this->educationSystemId)->pluck('title', 'id')->toArray();
        if ($item->college_id != $this->college->id) {
            abort(404);
        }
        $halls = Hall::where('college_id', $this->college->id)->where('system_id', $this->educationSystemId)->pluck('title', 'id')->toArray();
        return view('training.disciplines.edit', compact('item', 'pulpits', 'teachers', 'halls'));
    }

    public function update(Request $request, $id)
    {
        $item = Discipline::find($id);
        if ($item->college_id != $this->college->id) {
            abort(404);
        }
        $data = $request->all();
        $item->update($data);
        \DB::table('discipline_user')->where('discipline_id', $item->id)->delete();
        if ($request->has('teachers')) {
            foreach ($request->get('teachers') as $t) {
                $item->users()->attach($t);
            }
        }
        return redirect('training/disciplines');
    }

    public function destroy($id)
    {
        $item = Discipline::find($id);
        if ($item->college_id != $this->college->id) {
            abort(404);
        }
        $item->delete();
        return redirect('training/disciplines');
    }
}
