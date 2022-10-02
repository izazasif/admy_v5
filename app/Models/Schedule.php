<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model {

    protected $table = 'schedules';

    protected $fillable = [
        
    ];

    protected $hidden = [
        //
    ];

    public function getCategory(){
        return $this->belongsTo(
                'App\Models\Category','category_id');
    }

    public function getAudioClip(){
        return $this->belongsTo(
                'App\Models\AudioClip','clip_id');
    }

    public function getUser(){
        return $this->belongsTo(
                'App\Models\User','user_id');
    }

}
