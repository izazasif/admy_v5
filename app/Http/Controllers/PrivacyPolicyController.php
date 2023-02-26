<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    public function index()
    {
        $title = "MyBdApps | Privacy Policy";
        return view('site.pages.privacy', compact('title'));
    }
}
