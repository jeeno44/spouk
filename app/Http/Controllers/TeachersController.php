<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Role;
use App\Models\User;

class TeachersController extends Controller
{
    public function index()
    {
        $users = Role::find(4)->users()->where('college_id', \Auth::user()->college_id)->get();
        return view('teachers.index', compact('users'));
    }

    public function create()
    {
        return view('teachers.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email'     => 'required|email|unique:users,email,'.\Auth::user()->id,
            'phone'     => 'required|unique:users,phone,'.\Auth::user()->id,
            'password'  => 'min:6|confirmed',
        ]);

        $data = $request->all();
        $password = $data['password'];
        $data['password'] = bcrypt($data['password']);

        if (empty($request->get('subdivision_id'))) {
            $data['subdivision_id'] = null;
        }

        if (empty($request->get('specialization_id'))) {
            $data['specialization_id'] = null;
        }

        $user = new User($data);
        $user->activation_code = str_random(32);
        $user->save();
        $user->roles()->attach(4);
        if ($request->has('levels')) {
            foreach ($request->get('levels') as $level) {
                $user->access()->attach($level);
            }
        }

        \Mail::send('auth.emails.create_teacher', compact('user', 'password'), function($message) use ($user) {
            $message->to($user->email)->subject('Для вас создан аккаунт в системе cont-spo.ru');
        });

        return redirect('college/teachers');
    }

    public function edit($id)
    {
        $user = User::find($id);
        if ($user->college_id == \Auth::user()->college_id) {
            return view('teachers.edit', compact('user'));
        }

        return redirect('college/teachers');
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $this->validate($request, [
            'email' => 'required|email|unique:users,email,'.$user->id,
            'phone' => 'required|unique:users,phone,'.$user->id,
        ]);

        $data = $request->all();
        if (empty($request->get('subdivision_id'))) {
            $data['subdivision_id'] = null;
        }

        if (empty($request->get('specialization_id'))) {
            $data['specialization_id'] = null;
        }

        if ($request->get('password')) {
            $this->validate($request, [
                'password' => 'min:6|confirmed',
            ]);
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);
        \DB::table('access_level_user')->where('user_id', $id)->delete();
        if ($request->has('levels')) {
            foreach ($request->get('levels') as $level) {
                $user->access()->attach($level);
            }
        }
        return redirect('college/teachers');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if ($user->college_id == \Auth::user()->college_id) {
            $user->email = str_random(8).'_'.$user->email;
            $user->save();
            $user->delete();
        }

        return redirect('college/teachers');
    }
}
