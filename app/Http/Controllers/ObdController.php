<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ObdController extends Controller
{
    public function analytics()
    {
        $title = "AdMy | Products Analytics";
        return view('site.pages.analytics', compact('title'));
    }
}
