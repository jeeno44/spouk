<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\PageRequest;

class ArticlesController extends Controller
{
    public function index()
    {
        $items = Article::orderBy('date', 'desc')->paginate(20);
        return view('admin.articles.index', compact('items'));
    }

    public function create()
    {
        $title = 'Добавить новость';
        return view('admin.articles.form', compact('title'));
    }

    public function store(PageRequest $request)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $fName = str_random().'.'.$request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('uploads/images'), $fName);
            $data['image'] = $fName;
        } else {
            $data['image'] = '';
        }
        if ($request->has('timestamp')) {
            $data['date'] = strtotime($request->get('timestamp'));
        } else {
            $data['date'] = strtotime(date('Y-m-d H:i'));
        }
        $page = new Article($data);
        $page->save();
        return redirect('admin/articles')->with('messages', ['Сохранено']);
    }

    public function edit($id)
    {
        $item = Article::find($id);
        $title = 'Редактирование новости';
        return view('admin.articles.form', compact('title', 'item', 'parents'));
    }

    public function update(PageRequest $request, $id)
    {
        $item = Article::find($id);
        $data = $request->all();
        if ($request->hasFile('image')) {
            $fName = str_random().'.'.$request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('uploads/images'), $fName);
            $data['image'] = $fName;
        }
        if ($request->has('timestamp')) {
            $data['date'] = strtotime($request->get('timestamp').':00');
        } else {
            $data['date'] = strtotime(date('Y-m-d H:i:s'));
        }
        $item->update($data);
        return redirect(\Session::get('previous_page', 'admin/articles'))->with('messages', ['Сохранено']);
    }

    public function destroy($id)
    {
        $item = Article::find($id);
        if (!empty($item)) {
            $item->delete();
        }
        return redirect()->back()->with('messages', ['Удалено']);
    }
}
