<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SMSPurchase extends Model
{
    protected $table = 's_m_s_purchases';
    protected $fillable = ['user_id','package_id','conversions','chanel'];
}
