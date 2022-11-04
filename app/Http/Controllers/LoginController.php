<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserPack;
use App\Models\Schedule;
use App\Models\Verification;
use App\Models\ForgotPassword;
use App\Models\LoginToken;
use Hash;
// use Mail;

class LoginController extends Controller
{
    public function signin()
    {
        $title = "AdMy | Sign In";
        return view('site.pages.signin', compact('title'));
    }

    public function signup()
    {
        $title = "AdMy | Sign Up";
        return view('site.pages.signup', compact('title'));
    }

    public function signupSubmit(Request $request){
        $rules = [
            'first_name' => 'required|string|max:30',
            'email' => 'required|email',
            'mobile_no' => 'required',
            'password' => 'required',
            'confirm_password' => 'required',
            'nid_copy' => 'max:1024|mimes:jpeg,jpg,png',
        ];

        $messages = [
            'first_name.required' => 'First Name field is required!',
            'first_name.max' => 'Maximum length for first name 30 char!',
            'email.required' => 'Email field is required!',
            'email.email' => 'Invalid email address!',
            'mobile_no.required' => 'Mobile Number field is required!',
            'password.required' => 'Password field is required!',
            'confirm_password.required' => 'Confirm Password field is required!',
            'nid_copy.mimes' => 'NID Copy image must be a file of type: jpeg, jpg, png!',
            'nid_copy.max' => 'NID Copy image may not be greater than 1 MB!',
        ];

        $this->validate($request, $rules, $messages);

        if($request->password != $request->confirm_password){
            return redirect()->back()->withErrors("Passwords didn't match!");
        }

        $checkUserData = User::where('email', $request->email)->first();

        if(!empty($checkUserData)){
            return redirect()->back()->withErrors("Email already exists!");
        }

        $nid_copy_path = null;
        if($request->file('nid_copy')){
            $file = $request->file('nid_copy');
            $destinationPath = 'account/nid';
            $fileName = 'nid_'.strtotime("now");
            if($file->getClientOriginalExtension() == 'jpg' || $file->getClientOriginalExtension() == 'jpeg'){
                $file->move($destinationPath, $fileName.'.jpg');
                $nid_copy_path = $destinationPath.'/'.$fileName.'.jpg';
            }
            if($file->getClientOriginalExtension() == 'png'){
                $file->move($destinationPath, $fileName.'.png');
                $nid_copy_path = $destinationPath.'/'.$fileName.'.png';
            }
        }

        $userData = new User;
        $userData->username = $request->first_name .' '.$request->last_name;
        $userData->mobile_no = $request->mobile_no;
        $userData->password = Hash::make($request->password);
        $userData->email = $request->email;
        $userData->nid_no = $request->nid_no;
        $userData->nid_path = $nid_copy_path;
        $userData->role = 'user';
        $userData->save();

        $verData = new Verification;
        $verData->user_id = $userData->id;
        $verData->token = strtotime("now");
        $verData->save();

        $body = "Please click the link ".route('verify',['id'=>$userData->id,'token'=>$verData->token])." to activate your Admy account. If you didn't request this link, you can safely ignore this email.";

        $logArray['time'] = date('Y-m-d H:i:s');
        $logArray['to'] = $userData->email;
        $logArray['subject'] = 'Admy: Account Verification';
        $logArray['body'] = $body;
        \Log::channel('email_dump')->info($logArray);

       \Mail::to($userData->email)->send(new \App\Mail\VerificationMail($body));

        $message = 'Account created successfully! Please check you email for account verification link.';

        return redirect()->back()->with('message',$message);
    }

    public function signinSubmit(Request $request){
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        $messages = [
            'email.required' => 'Email field is required!',
            'email.email' => 'Invalid email address!',
            'password.required' => 'Password field is required!',
        ];

        $this->validate($request, $rules, $messages);

        $output = User::where('email', $request->email)->first();

		if ($output && Hash::check($request->password, $output->password) && $output->is_verified && $output->status) {
			session()->put('user_id', $output->id);
            session()->put('user_mail', $output->email);
            session()->put('user_username', $output->username);
            session()->put('user_role', $output->role);

            // $logToken = strtotime("now").uniqid();
            // session()->put('login_token', $logToken);

            // $oldLogToken = LoginToken::where('user_id', $output->id)->first();
            // if(empty($oldLogToken)){
            //     $tokenData = new LoginToken;
            //     $tokenData->user_id = $output->id;
            //     $tokenData->token = $logToken;
            //     $tokenData->status = 1;
            //     $tokenData->save();
            // }else{
            //     $oldLogToken->token = $logToken;
            //     $oldLogToken->status = 1;
            //     $oldLogToken->save();
            // }

            $user_credit = UserPack::where('user_id', $output->id)->where('valid_till', '>=', date('Y-m-d H:i:s'))->where('status', 1)->sum('amount');
            $user_debit = Schedule::where('user_id', $output->id)->sum('obd_amount');
            session()->put('user_credit', $user_credit-$user_debit);
dd('hola');
            $userPushSMSBalance = getUserPushSMSBalance($output->id);
            session()->put('user_sms_credit', $userPushSMSBalance);

            if(session()->has('url_to_serve')){
                $url = session()->get('url_to_serve');
                session()->forget('url_to_serve');
                return redirect($url);
            }else{
                return redirect()->route('home');
            }
		} else {
            return redirect()->back()->withErrors("Invalid credentials or account!");
		}
    }

    public function logout(){
        $user_id = session()->get('user_id');
        // $logToken = session()->get('login_token');

        // $dbLogToken = LoginToken::where('user_id', $user_id)->where('token', $logToken)->first();
        // if($dbLogToken){
        //     $dbLogToken->status = 0;
        //     $dbLogToken->save();
        // }

        session()->flush();
        \Cookie::forget('laravel_session');
    	$message="Successfully Logged out!";
    	return redirect()->route('signin')->with('message',$message);
    }

    public function verify($id, $token){

        $verData = Verification::where('user_id', $id)
                                ->where('token', $token)
                                ->where('status', 0)
                                ->first();

        if($verData){
            $verData->status = 1;
            $verData->save();

            $output = User::where('id', $id)->first();

            session()->put('user_id', $output->id);
            session()->put('user_mail', $output->email);
            session()->put('user_username', $output->username);
            session()->put('user_role', $output->role);

            $user_credit = UserPack::where('user_id', $output->id)->where('valid_till', '>=', date('Y-m-d H:i:s'))->where('status', 1)->sum('amount');
            $user_debit = Schedule::where('user_id', $output->id)->sum('obd_amount');
            session()->put('user_credit', $user_credit-$user_debit);

            $output->is_verified = 1;
            $output->save();

            $userPushSMSBalance = getUserPushSMSBalance($output->id);
            session()->put('user_sms_credit', $userPushSMSBalance);

    	    return redirect()->route('home');
        }else{
            return redirect()->route('home');
        }
    }

    public function reset($id, $token){
        $user_id = $id;
        $fpData = ForgotPassword::where('user_id', $user_id)
                                ->where('token', $token)
                                ->where('status', 0)
                                ->first();

        if($fpData){
            $title = "AdMy | Forgot Password";
            return view('site.pages.forgot_pass', compact('title', 'user_id', 'token'));
        }else{
            return redirect()->route('home');
        }
    }

    public function forgot(){
        $title = "AdMy | Forgot Password";
        return view('site.pages.forgot_email', compact('title'));
    }

    public function forgotEmailSubmit(Request $request){
        $rules = [
            'email' => 'required|email',
        ];

        $messages = [
            'email.required' => 'Email field is required!',
            'email.email' => 'Invalid email address!',
        ];

        $this->validate($request, $rules, $messages);

        $userData = User::where('email', $request->email)->where('is_verified', 1)->where('status', 1)->first();
        if(empty($userData)){
            return redirect()->back()->withErrors("Invalid email address!");
        }

        $fpData = new ForgotPassword;
        $fpData->user_id = $userData->id;
        $fpData->token = strtotime("now");
        $fpData->save();

        $body = "Please click the link ".route('reset',['id'=>$userData->id,'token'=>$fpData->token])." to reset password of your Admy account. If you didn't request this link, you can safely ignore this email.";

        $logArray['time'] = date('Y-m-d H:i:s');
        $logArray['to'] = $userData->email;
        $logArray['subject'] = 'Admy: Password Reset';
        $logArray['body'] = $body;
        \Log::channel('email_dump')->info($logArray);

        \Mail::to($userData->email)->send(new \App\Mail\PasswordResetMail($body));

        $message = 'Please check you email for password reset link.';
        return redirect()->back()->with('message',$message);
    }

    public function forgotPassSubmit(Request $request){
        $rules = [
            'password' => 'required',
            'confirm_password' => 'required',
        ];

        $messages = [
            'password.required' => 'Password field is required!',
            'confirm_password.required' => 'Confirm Password field is required!',
        ];

        $this->validate($request, $rules, $messages);

        if($request->password != $request->confirm_password){
            return redirect()->back()->withErrors("Passwords didn't match!");
        }

        $userData = User::where('id', $request->user_id)->first();
        $userData->password = Hash::make($request->password);
        $userData->save();

        $fpData = ForgotPassword::where('user_id', $request->user_id)
                                ->where('token', $request->token)
                                ->where('status', 0)
                                ->first();
        $fpData->status = 1;
        $fpData->save();

        $message = 'Password reset successfully. Please login now!';
        return redirect()->route('signin')->with('message',$message);
    }

}
