<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\SMSSchedule;
use Illuminate\Http\Request;
use GuzzleHttp\Client as GuzzleClient;

class CampainController extends Controller
{
    public function getUserKey(){
        date_default_timezone_set("Asia/Dhaka");
        $url = "https://api.joycalls.com:48080/login";
        $user = "bdapps";
        $password  = "HYoDu92OGFk2#H";
        $current_time = date('d-m-Y H:i:s');
        $all = $user.$password.$current_time;
        $hash = hash('sha256', $all);
        $headers = array(
            'Content-Type:application/json',
        );

        $params = array(
            'user' => $user,
            'hash' => $hash
        );
        $params = json_encode($params);
        $crl = curl_init();
        curl_setopt($crl,CURLOPT_URL,$url);
        curl_setopt($crl,CURLOPT_HTTPHEADER,$headers);
        curl_setopt($crl,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($crl,CURLOPT_POST,true);
        curl_setopt($crl,CURLOPT_POSTFIELDS,$params);
        $response = curl_exec($crl);
        curl_close($crl);
        $response = json_decode($response);
        return $response->key;
    }

    public function purchasePackage($client_id,$conversions){
        $user = User::find($client_id);
        if($user) {
            $data = array(
                'client' => $user->email,
                'conversions' => $conversions,
                'channel' => "push"
            );
            $data_raw = json_encode($data);
            $headers = array(
                'Content-Type:application/json',
                'x-api-key: '.$this->getUserKey(),
            );
            $url = 'https://api.joycalls.com:48080/packages';
            $crl = curl_init();
            curl_setopt($crl, CURLOPT_URL, $url);
            curl_setopt($crl, CURLOPT_HEADER, false);
            curl_setopt($crl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($crl, CURLOPT_POST, true);
            curl_setopt($crl, CURLOPT_POSTFIELDS, $data_raw);
            $response = curl_exec($crl);
            curl_close($crl);
            $response = json_decode($response);
            return $response;
        }else{
            return -1;
        }

    }

    public function createCampaign($client_id,$schedule_id){
        $user = User::find($client_id);
        $schedule = SMSSchedule::find($schedule_id);
        $date=date_create($schedule->schedule_time);
        $formated_date = date_format($date,'d-m-Y H:i');
        if($user && $schedule) {
            $data = array(
                'client' => $user->email,
                'channel' => "push",
                'appid' => $schedule->app_id,
                'conversions' => $schedule->sms_amount,
                'category' => $schedule->text->category->title,
                'scheduledStart' => $formated_date,
            );
            $data_raw = json_encode($data);
            $headers = array(
                'Content-Type:application/json',
                'x-api-key: '.$this->getUserKey(),
            );
            $url = 'https://api.joycalls.com:48080/campaigns';
            $crl = curl_init();
            curl_setopt($crl, CURLOPT_URL, $url);
            curl_setopt($crl, CURLOPT_HEADER, false);
            curl_setopt($crl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($crl, CURLOPT_POST, true);
            curl_setopt($crl, CURLOPT_POSTFIELDS, $data_raw);
            $response = curl_exec($crl);
            curl_close($crl);
            $response = json_decode($response);
            return $response;
        }else{
            return -1;
        }
    }

    public function getCampainInformation($campain_id){
        $headers = array(
            'Content-Type:application/json',
            'x-api-key: '.$this->getUserKey(),
        );
        $url = 'https://api.joycalls.com:48080/campaigns/'.$campain_id;
        $crl = curl_init();
        curl_setopt($crl, CURLOPT_URL, $url);
        curl_setopt($crl, CURLOPT_HEADER, false);
        curl_setopt($crl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($crl);
        curl_close($crl);
        $response = json_decode($response);
        return $response;
    }

    public function smsCampaingStat(Request $request){
        try{
            $token = $this->getUserKey();
            $clientid = $request->session()->get('user_mail');
            $users = '';
            $view = 'portal.sms_schedule.campain_stat_user';
            $is_active = "campaing_stat"; 
            if($request->clientId && $request->session()->get('user_role') == 'admin' ){
                session()->put('clientId', $request->clientId);
                $clientid = $request->clientId;
                $users = User::where('status',1)->where('role','user')->get();
                $view = 'portal.sms_schedule.campain_stat_admin';
                $is_active = "campaing_stat_admin"; 
            }
            session()->put('dateRangeStat', $request->dateRange);
            
            $f = trim(explode("-",$request->dateRange)[0]," ");
            $t = trim(explode("-",$request->dateRange)[1]," ");
            $from = \Carbon\Carbon::createFromFormat('m/d/Y', $f)->format('d-m-Y');
            $to = \Carbon\Carbon::createFromFormat('m/d/Y', $t)->format('d-m-Y');

            $qstring = '?from=' .$from.'&to='.$to.'&clientid='.$clientid;

            //api call
            $headers = [
                'x-api-key' => $token,
            ];
            $client = new GuzzleClient([
                'headers' => $headers
            ]);
            $url = 'https://api.joycalls.com:48080/stats' . $qstring;
            $result = $client->request('GET', $url);
            
            $title = "AdMy | Campaing Stat";
                   
            $decode_result = json_decode($result->getBody()->getContents());
            $data = $decode_result->stats;

            return view($view, compact('title','is_active','users','data'));
        }
    
        catch (\Exception $e) { 
            $title = "AdMy | Campaing Stat";
            $users="";
            $data = "";
            $is_active = "campaing_stat";
            $view = 'portal.sms_schedule.campain_stat_user';
            $message = 'Error occured, Try later!!';
            session()->put('message', $message);
            if($request->session()->get('user_role') == 'admin' ){
                    $users = User::where('status',1)->where('role','user')->get();
                    $view = 'portal.sms_schedule.campain_stat_admin';
                    $is_active = "campaing_stat_admin"; 
                }
            return view($view, compact('title','is_active','users','data'));	
	    }
    }
    
    public function smsCampaingStat2(){
        $title = "AdMy | Campaing Stat";
        $is_active = "campaing_stat_admin";
        $token = $this->getUserKey();
        $clientid = (request()->query('user'));
        $daterange = (request()->query('daterange'));
        session()->put('dateRangeStat', $daterange);
        session()->put('clientId', $clientid);
        $f = trim(explode("-",$daterange)[0]," ");
        $t = trim(explode("-",$daterange)[1]," ");
        $from = \Carbon\Carbon::createFromFormat('m/d/Y', $f)->format('d-m-Y');
        $to = \Carbon\Carbon::createFromFormat('m/d/Y', $t)->format('d-m-Y');

        $qstring = '?from=' .$from.'&to='.$to.'&clientid='.$clientid;

        $headers = [
            'x-api-key' => $token,
        ];
        $client = new GuzzleClient([
            'headers' => $headers
        ]);

        $url = 'https://api.joycalls.com:48080/stats' . $qstring;
        $result = $client->request('GET', $url);
        $users = User::where('status',1)->where('role','user')->get();
        $decode_result = json_decode($result->getBody()->getContents());
        $data = $decode_result->stats;
        return view('portal.sms_schedule.campain_stat_admin', compact('title','users','is_active','data'));
    }   
}
