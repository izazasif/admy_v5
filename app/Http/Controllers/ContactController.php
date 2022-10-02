<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index(){
        
    }

    public function store(Request $request){
      $rules = [
            'name' => 'required',
            'email' => 'required|email',
          'subject' => 'required',
          'message' => 'required',
      ];
      
      $messages = [
        'name.required' => 'Name field is required!',
        'email.required' => 'Email field is required!',
        'email.email' => 'Invalid email address!',
          'subject.required' => 'Subject field is required!',
          'details.required' => 'Message field is required!',
      ];
      
      $this->validate($request, $rules, $messages);

      $contactData = new Contact;
      $contactData->name = $request->name;
      $contactData->email = $request->email;
      $contactData->subject = $request->subject;
      $contactData->message = $request->message;
      $contactData->save();

      $message = 'Message sent successfully!';
      return redirect()->back()->with('message',$message);
    }


}
