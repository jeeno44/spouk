<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Feedback;
use App\Models\Page;
use Illuminate\Http\Request;

use App\Http\Requests;

class FrontendController extends Controller
{
    public function index()
    {
        return view('frontend.index');
    }

    public function page($slug)
    {
        $page = Page::where('slug', $slug)->first();
        if (!$page) {
            abort(404);
        }
        return view('frontend.page', compact('page'));
    }

    public function getFeedback()
    {
        return view('frontend.feedback');
    }

    public function postFeedback(Request $request)
    {
        $data = $request->all();
        $data['text'] = $data['message'];
        $feedback = Feedback::create($data);
        \Mail::send('emails.feedback', compact('feedback'), function($message) use ($feedback) {
            $message->to('l-and@buro3v.ru')->subject('Обратная связь с edu360');
        });
        return redirect('/feedback');
    }

    public function news($slug = null)
    {
        if (!$slug) {
            return redirect('/');
        }
        $new = Article::where('slug', $slug)->first();
        if (!$new) {
            abort(404);
        }
        return view('frontend.news-item', compact('new'));
    }
}
