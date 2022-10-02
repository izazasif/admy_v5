<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\SMSSchedule;
use Illuminate\Http\Request;

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

    public function createCampaign($client_id,$schedule_id,$category='chat'){
        $user = User::find($client_id);
        $schedule = SMSSchedule::find($schedule_id);
        $date=date_create($schedule->schedule_time);
        $formated_date = date_format($date,'d-m-Y H:i');
        if($user && $schedule) {
            $data = array(
                'client' => '123@test.com',
                'channel' => "push",
                'appid' => $schedule->app_id,
                'conversions' => $schedule->sms_amount,
                'category' => $category,
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
}
