<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SMSText extends Model
{
    protected $table = 's_m_s_texts';
    protected $fillable = ['category_id','text','status'];

    public function category(){
        return $this->belongsTo('App\Models\Category','category_id');
    }
}
