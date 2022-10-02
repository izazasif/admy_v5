<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebPaymentHistory extends Model
{
    protected $table = 'web_payment_histories';
    protected $fillable = ['user_web_api_id','trxID','transactionStatus','amount','intent','merchantInvoiceNumber'];
}
