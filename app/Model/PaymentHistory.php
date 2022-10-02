<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    protected $table = 'payment_histories';
    protected $fillable = ['user_sms_id','trxID','transactionStatus','amount','intent','merchantInvoiceNumber'];
}
