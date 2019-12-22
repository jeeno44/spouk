<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\System;

class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth', ['except' => 'changeEducationSystem']);
    }

    public function index()
    {
        $college = \Auth::user()->college;
        $events = Event::where('college_id', $college->id)->latest()->take(10)->get();
        return view('welcome', compact('college', 'events'));
    }

    public function changeEducationSystem($id = null)
    {
        if ($id) {
            $system = System::find($id);
            if (!$system || !$system->enabled) {
                abort(404);
            }
            if ($id == 1) {
                return redirect('http://spo.'.config('app.domain'));
            }
            if ($id == 2) {
                return redirect('http://vo.'.config('app.domain'));
            }
        } else {
            \Session::set('pu', \URL::previous());
            return view('dashboard.system');
        }
    }
}
