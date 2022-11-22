<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;

class AdminController extends Controller
{
    public function index(){
        $title = "AdMy | Admin User List";
        $is_active = "admin_list";

        $admin_users = User::where('role', 'admin')->paginate(50);

        return view('portal.admin.list', compact('title', 'is_active', 'admin_users'));
    }

    public function create(){
        $title = "AdMy | Create Admin User";
        $is_active = "admin_create";

        return view('portal.admin.create', compact('title', 'is_active'));
    }

    public function store(Request $request){
      $rules = [
        'username' => 'required',
        'email' => 'required|email',
        'password' => 'required',
        'confirm_password' => 'required',
        'status' => 'required',
        'user_permission' => 'required',
      ];
      
      $messages = [
        'username.required' => 'Username field is required!',
        'email.required' => 'Email field is required!',
        'email.email' => 'Invalid email address!',
        'password.required' => 'Password field is required!',
        'confirm_password.required' => 'Confirm Password field is required!',
        'status.required' => 'Status field is required!',
        'user_permission.required' => 'Permission field is required!',
      ];
      
      $this->validate($request, $rules, $messages);

      if($request->password != $request->confirm_password){
        return redirect()->back()->withErrors("Passwords didn't match!");
      }

      $checkUserData = User::where('email', $request->email)->first();

      if(!empty($checkUserData)){
        return redirect()->back()->withErrors("Email already exists!");
      }

        $userData = new User;
        $userData->username = $request->username;
        $userData->password = Hash::make($request->password);
        $userData->email = $request->email;
        $userData->role = 'admin';
        $userData->is_verified = 1;
        $userData->status = $request->status;
        $userData->permission = $request->user_permission;
        $userData->save(); 

      $message = 'Admin user created successfully!';
      return redirect()->route('admin.list')->with('message',$message);
    }

    public function edit($id){
      $title = "AdMy | Edit Admin User";
      $is_active = "admin_edit";

      $adminDetail = User::where('id', $id)->first();

      return view('portal.admin.edit', compact('title', 'is_active', 'adminDetail'));
    }

    public function update(Request $request){
      $rules = [
        'username' => 'required',
        'status' => 'required',
      ];
      
      $messages = [
          'username.required' => 'Username field is required!',
          'status.required' => 'Status field is required!',
      ];
      
      $this->validate($request, $rules, $messages);

      if($request->password){
          if($request->password != $request->confirm_password){
            return redirect()->back()->withErrors("Passwords didn't match!");
          }
      }

      $user_id = $request->user_id;

      $userData = User::where('id', $user_id)->first();
      $userData->username = $request->username;
      if($request->password){
        $userData->password = Hash::make($request->password);
      }
      
      if($request->user_permission){
        $userData->permission = $request->user_permission;
      }
      $userData->status = $request->status;
      $userData->save();

      $message = 'Admin user updated successfully!';
      return redirect()->route('admin.list')->with('message',$message);
    }

    public function userList(){
        $title = "AdMy | User List";
        $is_active = "user_list";

        $users = User::where('role', 'user')->paginate(50);

        return view('portal.user.list', compact('title', 'is_active', 'users'));
    }

    public function userUpdateActive($id){
        $userData = User::where('id', $id)->first();
        $userData->status =  1;
        $userData->save();

        $message = 'User status updated successfully!';
        return redirect()->route('user.list')->with('message',$message);
    }

    public function userUpdateInactive($id){
        $userData = User::where('id', $id)->first();
        $userData->status =  0;
        $userData->save();

        $message = 'User status updated successfully!';
        return redirect()->route('user.list')->with('message',$message);
    }

}
