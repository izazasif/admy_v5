<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\WebAPISchedule;
use Illuminate\Http\Request;

class WebAPIScheduleController extends Controller
{
    public function create()
    {
        $title = "MyBdApps | Create Web API Schedule";
        $is_active = "create_web_schedule";
        $categories = Category::where('status', 1)->get();

        return view('portal.web-api.schedule', compact('title', 'is_active','categories'));
    }

    public function store(Request $request){
        $rules = [
            'schedule_datetime' => 'required',
            'category_id' => 'required',
            'app_id' => 'required',
            'app_name' => 'required',
            'app_type' => 'required',
            'dev_name' => 'required',
            'dev_email' => 'required',
            'dev_number' => 'required',
        ];

        $messages = [
            'schedule_datetime.required' => 'Select Date & Time field is required!',
            'category_id' => 'Category field is required!',
            'app_id.required' => 'App ID field is required!',
            'app_name.required' => 'App Name field is required!',
            'app_type.required' => 'APP Type field is required!',
            'dev_name.required' => 'Developer name field is required!',
            'dev_email.required' => 'Developer email field is required!',
            'dev_number.required' => 'Developer number  field is required!',
        ];

        $this->validate($request, $rules, $messages);
        $user_id = session()->get('user_id');

        if($request->file('deposit_slip')){
            $file= $request->file('deposit_slip');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('slips'), $filename);
        }

        $scheduleData = new WebAPISchedule();
        $scheduleData->user_id = $user_id;
        $scheduleData->category_id = $request->category_id;
        $scheduleData->app_id = $request->app_id;
        $scheduleData->app_name = $request->app_name;
        $scheduleData->app_type = $request->app_type;
        $scheduleData->schedule_time = date('Y-m-d H:i:s', strtotime($request->schedule_datetime));
        $scheduleData->dev_name = $request->dev_name;
        $scheduleData->dev_email = $request->dev_email;
        $scheduleData->dev_number = $request->dev_number;
        $scheduleData->deposit_slip = $filename;

        $scheduleData->save();
        $message = 'Schedule saved successfully! In case of technical difficulties, we will deliver your schedule within 72 hours.';

        return redirect()->back()->with('message',$message);
    }

    public function list(Request $request)
    {
        $title = "MyBdApps | Web API Schedule List";
        $is_active = "web_api_schedule_list";
        $all_schedule_list = WebAPISchedule::paginate(20);
        return view('portal.web-api.schedule_list', compact('title', 'is_active', 'all_schedule_list'));
    }
    public function userList(Request $request)
    {
        $user_id = session()->get('user_id');
        $title = "MyBdApps | Web API Schedule List";
        $is_active = "web_api_schedule_list";
        $all_schedule_list = WebAPISchedule::where('user_id',$user_id)->paginate(20);
        return view('portal.web-api.user_schedule_list', compact('title', 'is_active', 'all_schedule_list'));
    }

    public function delivered($id){
        $schedule = WebAPISchedule::where('id',$id)->first();
        if ($schedule) {
            $schedule->status = 1;
            $success = $schedule->save();
            if ($success){
                $message = "Web API schedule successfully Delivered";
            }else{
                $message = "Something Wrong";
            }
        }else{
            $message = "Select Wrong shedule";
        }
        return redirect()->back()->with('message',$message);
    }
}
