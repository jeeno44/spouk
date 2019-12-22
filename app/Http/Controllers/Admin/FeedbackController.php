<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Models\Feedback;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class FeedbackController extends AdminController
{
    public function index()
    {
        $items = Feedback::latest()->paginate(20);
        return view('admin.feedback.index', compact('items'));
    }
}
