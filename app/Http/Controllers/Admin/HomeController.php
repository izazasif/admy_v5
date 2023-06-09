<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return redirect(route('admin.home'));
    }

    public function home()
    {
        $title = "MyBdApps | Home";
        return view('admin.home.index', compact('title'));
    }
}
