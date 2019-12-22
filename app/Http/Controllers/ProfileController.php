<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\College;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users,email,'.\Auth::user()->id,
            'phone' => 'required|unique:users,phone,'.\Auth::user()->id,
        ]);

        $data = $request->all();
        if ($request->get('password')) {
            $this->validate($request, ['password' => 'min:6|confirmed',]);
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        \Auth::user()->update($data);
        return redirect()->back();
    }

    public function college()
    {
        $college = College::find(\Auth::user()->college_id);
        return view('profile.college', compact('college'));
    }

    public function storeCollege(Request $request)
    {
        $college = College::find(\Auth::user()->college_id);
        $this->validate($request, [
            'title' => 'required|min:6|unique:colleges,title,'.$college->id,
            'phone' => 'required|min:6|unique:colleges,phone,'.$college->id,
        ]);

        $college->update($request->all());
        return redirect()->back();
    }
}
