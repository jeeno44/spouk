<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

use App\Models\SpecializationGroup;
use App\Models\User;
use App\Models\Dictionary;

class GroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = SpecializationGroup::leftJoin('specializations', 'specializations.id', '=', 'specializations_groups.specialization_id')
            ->where('specializations.system_id', $this->educationSystemId)
            ->where('specializations.college_id', $this->college->id)
            ->select('specializations_groups.*')->get();
        return view('groups.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $listTeachers = User::getTeachers();

        $listSemester = [1 => 1, 2 => 2];
        $listCourse  =  Course::where('college_id', $this->college->id)
            ->where('system_id', $this->educationSystemId)->get();

        return view('groups.create')->with(['listTeachers' => $listTeachers, 'listSemester' => $listSemester, 'listCourse' => $listCourse]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        SpecializationGroup::create($request->all());
        return redirect('dec/groups');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $listTeachers = User::getTeachers();
        $item = SpecializationGroup::find($id);

        $listSemester = [1 => 1, 2 => 2];
        $listCourse  =  Course::where('college_id', $this->college->id)
            ->where('system_id', $this->educationSystemId)->get();

        return view('groups.edit', compact('item', 'listTeachers', 'listSemester', 'listCourse'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $item = SpecializationGroup::find($id);
        $item->update($request->all());
        return redirect('dec/groups');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = SpecializationGroup::find($id);
        $item->delete();
        return redirect('dec/groups');
    }
}
