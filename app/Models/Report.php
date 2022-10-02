<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model {

    protected $table = 'reports';

    protected $fillable = [
        
    ];

    protected $hidden = [
        //
    ];

    public function getSchedule(){
        return $this->belongsTo(
                'App\Models\Schedule','schedule_id');
    }


}
