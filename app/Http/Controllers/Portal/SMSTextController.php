<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SMSText;
use App\SMS;
use Illuminate\Http\Request;

class SMSTextController extends Controller
{
    public function index(){
        $title = "MyBdApps | SMS Text List";
        $is_active = "sms_text_list";
        $lists = SMSText::paginate(50);
        return view('portal.sms_text.list', compact('title', 'is_active', 'lists'));
    }

    public function create(){
        $title = "MyBdApps | Create SMS Text";
        $is_active = "sms_text_create";

        $categories = Category::where('status', 1)->get();

        return view('portal.sms_text.create', compact('title', 'is_active', 'categories'));
    }

    public function store(Request $request){
        $rules = [
            'category_id' => 'required',
            'text' => 'required',
            'status' => 'required',
        ];

        $messages = [
            'category_id.required' => 'Category field is required!',
            'text.required' => 'SMS Text field is required!',
            'status.required' => 'Status field is required!',
        ];

        $this->validate($request, $rules, $messages);


        $text = new SMSText();
        $text->category_id = $request->category_id;
        $text->text = $request->text;
        $text->status = $request->status;
        $text->save();

        $message = 'SMS text created successfully!';
        $log_write = storeActivityLog('SMS','SMS Text Create',json_encode($request->all()));
        return redirect()->route('sms.text.list')->with('message',$message);
    }

    public function edit($id){
        $title = "MyBdApps | Edit SMS Text";
        $is_active = "sms_text_edit";

        $categories = Category::where('status', 1)->get();
        $smsDetail = SMSText::where('id',$id)->first();

        return view('portal.sms_text.edit', compact('title', 'is_active', 'categories', 'smsDetail'));
    }

    public function update(Request $request){
        $rules = [
            'category_id' => 'required',
            'text' => 'required',
            'status' => 'required',
        ];

        $messages = [
            'category_id.required' => 'Category field is required!',
            'text.required' => 'Text field is required!',
            'status.required' => 'Status field is required!',
        ];

        $this->validate($request, $rules, $messages);

        $id = $request->id;

        $smsData = SMSText::where('id', $id)->first();
        $smsData->category_id = $request->category_id;
        $smsData->text = $request->text;
        $smsData->status = $request->status;
        $smsData->save();

        $message = 'SMS Text updated successfully!';
        $log_write = storeActivityLog('SMS','SMS Text Update',json_encode($request->all()));
        return redirect()->route('sms.text.list')->with('message',$message);
    }
}
