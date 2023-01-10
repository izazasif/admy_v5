<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\UserPack;
use App\Models\Pack;
use App\Models\Schedule;
use PDF;
use App\Http\Controllers\PackController;

class PaymentController extends Controller
{
    public function paymentCreate(Request $request){
        $id_token = session()->get('id_token');
        $amount = $request->amount;
        $invoice = uniqid(); // must be unique
        // $invoice = 'ABCD';
        $intent = "sale";
        $proxy = \Config::get('bkash.proxy');
        $createpaybody=array('amount'=>$amount, 'currency'=>'BDT', 'merchantInvoiceNumber'=>$invoice,'intent'=>$intent);   
        $url = curl_init(\Config::get('bkash.createURL'));

        $createpaybodyx = json_encode($createpaybody);

        $header=array(
            'Content-Type:application/json',
            'authorization:'.$id_token,
            'x-app-key:'.\Config::get('bkash.app_key')
        );

        curl_setopt($url,CURLOPT_HTTPHEADER, $header);
        curl_setopt($url,CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url,CURLOPT_POSTFIELDS, $createpaybodyx);
        curl_setopt($url,CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url,CURLOPT_TIMEOUT,30);
        //curl_setopt($url, CURLOPT_PROXY, $proxy);
        
        $resultdata = curl_exec($url);
        curl_close($url);
        echo $resultdata;
    }

    public function paymentExecute(Request $request){
        $id_token = session()->get('id_token');
        $paymentID = $request->paymentID;
        $proxy = \Config::get('bkash.proxy');

        $url = curl_init(\Config::get('bkash.executeURL').$paymentID);

        $header=array(
            'Content-Type:application/json',
            'authorization:'.$id_token,
            'x-app-key:'.\Config::get('bkash.app_key')              
        );	
            
        curl_setopt($url,CURLOPT_HTTPHEADER, $header);
        curl_setopt($url,CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url,CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url,CURLOPT_TIMEOUT,30);
        //curl_setopt($url, CURLOPT_PROXY, $proxy);

        $resultdatax=curl_exec($url);
        if (curl_errno($url)) {
            $error_msg = curl_error($url);
        }
        curl_close($url);

        if (isset($error_msg)) {
            // do it
            $getQueryPaymentData=$this->get_Payment_Query($paymentID, $id_token);
            $res = json_decode($getQueryPaymentData);
            if($res->transactionStatus == 'Completed'){
                $user_id = session()->get('user_id');

                //trx data store
                $trxData = new Transaction;
                $trxData->user_id = $user_id;
                $trxData->pack_id = $request->packID;
                $trxData->transaction_id = $res->trxID;
                $trxData->invoice_id = $res->merchantInvoiceNumber;
                $trxData->payment_id = $res->paymentID;
                $trxData->raw_response = $getQueryPaymentData;
                $trxData->status = 1;
                $trxData->save();

                //purchase update
                $packDetails = Pack::where('id', $request->packID)->first();

                $userPackData = new UserPack;
                $userPackData->user_id = $user_id;
                $userPackData->pack_id = $request->packID;
                $userPackData->amount = $packDetails->amount;
                $userPackData->valid_till = date('Y-m-d H:i:s', strtotime(now() . ' +'.$packDetails->validity.' day'));
                $userPackData->save();

                $user_credit = UserPack::where('user_id', $user_id)->where('valid_till', '>=', date('Y-m-d H:i:s'))->where('status', 1)->sum('amount');
                $user_debit = Schedule::where('user_id', $user_id)->sum('obd_amount');
                session()->put('user_credit', $user_credit-$user_debit);

                $data = PackController::invoiceData($userPackData->id);
                $pdf = PDF::loadView('portal.pack.obdinvoice', compact('data'));
                $body = 'Dear Developer, <br/> you have purchased '.$data->amount. ' amount of OBD.<br/> '.'Total price '.$data->price. ' (Included VAT 5% and Getway Charge 1%).<br/>please, find attached the invoice.';
                $msg = new \App\Mail\InvoiceMail($body);
                $msg->attachData($pdf->output(), 'OBD'.$userPackData->id.'-invoice.pdf');
                \Mail::to($data->email)->send($msg);
            }else{
                $message = 'Something went wrong! Please try again.';
                return redirect()->route('pack.purchase')->withErrors($message);
            }
        }else{
            $res = json_decode($resultdatax);
            $user_id = session()->get('user_id');

            if($res && isset($res->paymentID)){
                //trx data store
                $trxData = new Transaction;
                $trxData->user_id = $user_id;
                $trxData->pack_id = $request->packID;
                $trxData->transaction_id = $res->trxID;
                $trxData->invoice_id = $res->merchantInvoiceNumber;
                $trxData->payment_id = $res->paymentID;
                $trxData->raw_response = $resultdatax;
                $trxData->status = 1;
                $trxData->save();

                //purchase update
                $packDetails = Pack::where('id', $request->packID)->first();

                $userPackData = new UserPack;
                $userPackData->user_id = $user_id;
                $userPackData->pack_id = $request->packID;
                $userPackData->amount = $packDetails->amount;
                $userPackData->valid_till = date('Y-m-d H:i:s', strtotime(now() . ' +'.$packDetails->validity.' day'));
                $userPackData->save();

                $user_credit = UserPack::where('user_id', $user_id)->where('valid_till', '>=', date('Y-m-d H:i:s'))->where('status', 1)->sum('amount');
                $user_debit = Schedule::where('user_id', $user_id)->sum('obd_amount');
                session()->put('user_credit', $user_credit-$user_debit);
                $data = PackController::invoiceData($userPackData->id);
                $pdf = PDF::loadView('portal.pack.obdinvoice', compact('data'));
                $body = 'Dear Developer, <br/> you have purchased '.$data->amount. ' amount of OBD.<br/> '.'Total price '.$data->price. ' (Included VAT 5% and Getway Charge 1%).<br/>please, find attached the invoice.';                
                \Mail::to($data->email)->send(new \App\Mail\InvoiceMail($body,$pdf->output()));
                // \Mail::to($data->email)->send(new \App\Mail\InvoiceMail($body))->attachData($pdf->output(), 'OBD'.$userPackData->id.'-invoice.pdf');
            }else{
                //trx data store
                $trxData = new Transaction;
                $trxData->user_id = $user_id;
                $trxData->pack_id = $request->packID;
                $trxData->error_code = $res->errorCode;
                $trxData->error_message = $res->errorMessage;
                $trxData->raw_response = $resultdatax;
                $trxData->status = 0;
                $trxData->save();
            }

            echo $resultdatax; 
        }

        
    }

    public function paymentSuccess(){
        $message = 'Payment is successful! Pack purchase completed.';
        
        return redirect()->route('pack.purchase')->with('message',$message);
    }

    public function paymentError($code){
        $message = 'Payment failed! '.\Config::get('bkasherrors.'.$code);
        
        return redirect()->route('pack.purchase')->withErrors($message);
    }

    function get_Payment_Query($paymentid, $token){
      
        $proxy = \Config::get('bkash.proxy');

        $url = curl_init(\Config::get('bkash.queryURL').$paymentid);

        $header=array(
            'Content-Type:application/json',
            'authorization:'.$token,
            'x-app-key:'.\Config::get('bkash.app_key')              
        );	
            
        curl_setopt($url,CURLOPT_HTTPHEADER, $header);
        curl_setopt($url,CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($url,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url,CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url,CURLOPT_TIMEOUT,30);
        //curl_setopt($url, CURLOPT_PROXY, $proxy);

        $queryData=curl_exec($url);
        curl_close($url);

        // $res = json_decode($queryData);
        return $queryData;
    }

    public function paymentQuery(Request $request){
        $id_token = session()->get('id_token');
        $paymentID = $request->paymentID;
        $proxy = \Config::get('bkash.proxy');

        $url = curl_init(\Config::get('bkash.queryURL').$paymentID);

        $header=array(
            'Content-Type:application/json',
            'authorization:'.$id_token,
            'x-app-key:'.\Config::get('bkash.app_key')              
        );	
            
        curl_setopt($url,CURLOPT_HTTPHEADER, $header);
        curl_setopt($url,CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($url,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url,CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url,CURLOPT_TIMEOUT,30);
        //curl_setopt($url, CURLOPT_PROXY, $proxy);

        $resultdatax=curl_exec($url);
        curl_close($url);

        dd($resultdatax);
    }

    public function paymentSearch(Request $request){
        $id_token = session()->get('id_token');
        $trxID = $request->trxID;
        $proxy = \Config::get('bkash.proxy');

        $url = curl_init(\Config::get('bkash.searchURL').$trxID);

        $header=array(
            'Content-Type:application/json',
            'authorization:'.$id_token,
            'x-app-key:'.\Config::get('bkash.app_key')              
        );	
            
        curl_setopt($url,CURLOPT_HTTPHEADER, $header);
        curl_setopt($url,CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($url,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url,CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url,CURLOPT_TIMEOUT,30);
        //curl_setopt($url, CURLOPT_PROXY, $proxy);

        $resultdatax=curl_exec($url);
        curl_close($url);

        dd($resultdatax);
    }
}