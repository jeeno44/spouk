<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Subdivision;

use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function index()
    {
        $items = Event::where('college_id', $this->college->id)
            ->where('system_id', $this->educationSystemId)->latest()->get();
        return view('events.index', compact('items'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['system_id'] = $this->educationSystemId;
        Event::create($data);
        return redirect('college/events');
    }

    public function edit($id)
    {
        $item = Event::find($id);
        if ($item->college_id != $this->college->id) {
            abort(404);
        }

        return view('events.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = Event::find($id);
        if ($item->college_id != $this->college->id) {
            abort(404);
        }

        $item->update($request->all());
        return redirect('college/events');
    }

    public function destroy($id)
    {
        $item = Event::find($id);
        if ($item->college_id != $this->college->id) {
            abort(404);
        }

        $item->delete();
        return redirect('college/events');
    }
}
