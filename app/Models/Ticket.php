<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model {

    protected $table = 'tickets';

    protected $fillable = [
        
    ];

    protected $hidden = [
        //
    ];

    public function getUser(){
        return $this->belongsTo(
                'App\Models\User','user_id');
    }


}
