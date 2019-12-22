<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\PageRequest;

class BannersController extends Controller
{
    public function index()
    {
        $items = Banner::all();
        return view('admin.banners.index', compact('items'));
    }

    public function create()
    {
        $title = 'Добавить баннеры';
        return view('admin.banners.form', compact('title'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $fName = str_random().'.'.$request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('uploads/images'), $fName);
            $data['image'] = $fName;
        } else {
            $data['image'] = '';
        }
        $page = new Banner($data);
        $page->save();
        return redirect('admin/banners')->with('messages', ['Сохранено']);
    }

    public function edit($id)
    {
        $item = Banner::find($id);
        $title = 'Редактирование баннера';
        return view('admin.banners.form', compact('title', 'item', 'parents'));
    }

    public function update(Request $request, $id)
    {
        $item = Banner::find($id);
        $data = $request->all();
        if ($request->hasFile('image')) {
            $fName = str_random().'.'.$request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('uploads/images'), $fName);
            $data['image'] = $fName;
        }
        $item->update($data);
        return redirect(\Session::get('previous_page', 'admin/banners'))->with('messages', ['Сохранено']);
    }

    public function destroy($id)
    {
        $item = Banner::find($id);
        if (!empty($item)) {
            $item->delete();
        }
        return redirect()->back()->with('messages', ['Удалено']);
    }
}
