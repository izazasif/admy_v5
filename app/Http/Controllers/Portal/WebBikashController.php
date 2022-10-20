<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\UserWebAPI;
use App\Models\WebPaymentHistory;
use Illuminate\Http\Request;

class WebBikashController extends Controller
{
    public $amount = 0;
    public $user_web_api_id;
    public function __construct()
    {
        $bkash_app_key = \Config::get('bkash.app_key');
        $bkash_app_secret = \Config::get('bkash.app_secret');
        $bkash_username = \Config::get('bkash.username');
        $bkash_password = \Config::get('bkash.password');
//        $bkash_base_url = \Config::get('bkash.tokenURL');
        $bkash_base_url = 'https://checkout.pay.bka.sh/v1.2.0-beta';


        $this->app_key = $bkash_app_key;
        $this->app_secret = $bkash_app_secret;
        $this->username = $bkash_username;
        $this->password = $bkash_password;
        $this->base_url = $bkash_base_url;

    }

    public function getToken(){
        session()->forget('bkash_token');

        $post_token = array(
            'app_key' => $this->app_key,
            'app_secret' => $this->app_secret
        );


        $post_token = json_encode($post_token);
        $header = array(
            'Content-Type:application/json',
            "password:$this->password",
            "username:$this->username"
        );
        $url_1 = $this->base_url.'/checkout/token/grant';
        $url = curl_init($url_1);
        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_HEADER, false);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $post_token);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        $resultdata = curl_exec($url);
        curl_close($url);
        $response = json_decode($resultdata, true);

        if($response) {
            if ($response['id_token']) {
                session()->put('bkash_token', $response['id_token']);
            }
            return $response['id_token'];
        }else{
            return -1;
        }
    }

    public function createPayment(Request $request){
        $token = session()->get('bkash_token');
        $this->amount = $request->amount;
        $data = array(
            'amount' => $request->amount,
            'intent' => 'sale',
            'currency' => 'BDT',
            'merchantInvoiceNumber' => rand(),
        );

        $request_data_json = json_encode($data);
        $header = array(
            'Content-Type:application/json',
            "authorization: $token",
            "x-app-key: $this->app_key"
        );
        $url_1 = $this->base_url.'/checkout/payment/create';
        $url = curl_init($url_1);
        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $request_data_json);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $resultdata = curl_exec($url);
        curl_close($url);
        $response = json_decode($resultdata);

        echo $resultdata;

    }

    public function executePayment(Request $request){
        $token = session()->get('bkash_token');
        $paymentID = $request->paymentID;
        $this->user_web_api_id = $request->user_web_api_id;
        $user_id = session()->get('user_id');
        $header = array(
            'Content-Type:application/json',
            "authorization:$token",
            "x-app-key:$this->app_key"
        );
        $url_1 = $this->base_url.'/checkout/payment/execute/'.$paymentID;
        $url = curl_init($url_1);
        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        $resultdata = curl_exec($url);
        if (curl_errno($url)) {
            $error_msg = curl_error($url);
        }
        curl_close($url);
        if(isset($error_msg)){
            $query_payment=$this->queryPayment($paymentID, $token);
            if($query_payment->transactionStatus=='Completed'){
                $this->amount = $query_payment->amount;
                $payment = new WebPaymentHistory();
                $payment->user_web_api_id = $this->user_web_api_id;
                $payment->payment_id = $query_payment->paymentID;
                $payment->trxID = $query_payment->trxID;
                $payment->amount = $query_payment->amount;
                $payment->intent = $query_payment->intent;
                $payment->transactionStatus = $query_payment->transactionStatus;
                $payment->merchantInvoiceNumber = $query_payment->merchantInvoiceNumber;
                $payment->save();
            }
        }else{
            $response = json_decode($resultdata);
            $this->amount = $response->amount;
            $payment = new WebPaymentHistory();
            $payment->user_web_api_id = $this->user_web_api_id;
            $payment->payment_id = $response->paymentID;
            $payment->trxID = $response->trxID;
            $payment->transactionStatus = $response->transactionStatus;
            $payment->amount = $response->amount;
            $payment->intent = $response->intent;
            $payment->merchantInvoiceNumber = $response->merchantInvoiceNumber;
            $payment->save();
        }

        echo $resultdata;
//        return json_decode($resultdata, true);
    }

    public function queryPayment($payment_id,$token){
        $token = session()->get('bkash_token');
        $paymentID = $payment_id;
        $header = array(
            'Content-Type:application/json',
            "authorization:$token",
            "x-app-key:$this->app_key"
        );
        $url_1 = $this->base_url.'/checkout/payment/query/'.$paymentID;
        $url = curl_init($url_1);
        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        $resultdata = curl_exec($url);
        curl_close($url);


        return json_decode($resultdata, true);
    }

    public function bkashSuccess($payment_id){
        $payment =  WebPaymentHistory::where('payment_id',$payment_id)->first();
        if($payment) {
            $user_id = session()->get('user_id');
            $user_sms = UserWebAPI::where('id', $payment->user_web_api_id)->first();
            $user_sms->payment_status = 'Completed';
            $user_sms->status = 1;
            $user_sms->save();
            $message = 'Payment is successful! Pack purchase completed.';
            return redirect()->route('web.api.purchase')->with('message', $message);
        }else{
            $message = 'Payment failed! ';
            return redirect()->route('web.api.purchase')->withErrors($message);
        }
    }

    public function bkashError($code){
        $message = 'Payment failed! '.\Config::get('bkasherrors.'.$code);
        return redirect()->route('web.api.purchase')->withErrors($message);
    }
}
