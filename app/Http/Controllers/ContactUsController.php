<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function contact()
    {
        $title = "AdMy | Contact Us";
        return view('site.pages.contact', compact('title'));
    }
}
