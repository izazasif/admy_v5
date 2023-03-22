<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\WebApi;
use App\SMS;
use Illuminate\Http\Request;
use App\Models\Pack;

class HomeController extends Controller
{
    public function index()
    {
        $title = "MyBdApps";
        $packs = Pack::where('status', 1)->limit(5)->get();
        $sms = SMS::where('status', 1)->where('sms_category','bulk')->limit(5)->get();
        $push_sms = SMS::where('status', 1)->where('sms_category','push')->limit(5)->get();
        // $push_sms = SMS::where('status', 1)->where('sms_category','push')->limit(3)->get();
        $condition = "in";
        return view('site.pages.index', compact('title', 'packs', 'condition','sms','push_sms'));
    }

    public function WebAPI()
    {
        $title = "MyBdApps | Web API";
        $packs = WebApi::where('status', 1)->where('acquisition','!=',0)->limit(3)->get();
        $single = WebApi::where('acquisition',0)->select('price')->first();
        $unit_price = $single->price;
        $arr = [];
        foreach ($packs as $pack){
            array_push($arr,$pack->id);
        }
        $nextPacks = WebApi::where('status', 1)->where('acquisition','!=',0)->WhereNotIn('id',$arr)->get();
        $condition = "out";
        return view('site.pages.web-api', compact('title', 'packs', 'condition','nextPacks','unit_price'));
    }

    public function phpinfo(){
        // echo phpinfo();
        return view('site.pages.test');
    }

}
