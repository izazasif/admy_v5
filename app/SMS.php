<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class SMS extends Model
{
    protected $table = 's_m_s';
    protected $fillable = ['name','sms_category','sms_type','price','unit_price','amount','validity','status'];

    

}
