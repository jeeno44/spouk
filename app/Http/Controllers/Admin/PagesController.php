<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Models\Page;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\PageRequest;

class PagesController extends Controller
{
    public function index()
    {
        $items = Page::latest()->paginate(20);
        return view('admin.pages.index', compact('items'));
    }

    public function create()
    {
        $title = 'Добавить страницу';
        return view('admin.pages.form', compact('title'));
    }

    public function store(PageRequest $request)
    {
        $page = new Page($request->all());
        $page->save();
        return redirect('admin/pages')->with('messages', ['Сохранено']);
    }

    public function edit($id)
    {
        $item = Page::find($id);
        $title = 'Редактирование страницы';
        return view('admin.pages.form', compact('title', 'item', 'parents'));
    }

    public function update(PageRequest $request, $id)
    {
        $item = Page::find($id);
        $item->update($request->all());
        return redirect(\Session::get('previous_page', 'admin/pages'))->with('messages', ['Сохранено']);
    }

    public function destroy($id)
    {
        $item = Page::find($id);
        if (!empty($item)) {
            $item->delete();
        }
        return redirect()->back()->with('messages', ['Удалено']);
    }
}
