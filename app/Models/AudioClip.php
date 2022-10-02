<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AudioClip extends Model {

    protected $table = 'audio_clips';

    protected $fillable = [
        
    ];

    protected $hidden = [
        //
    ];

    public function getCategory(){
        return $this->belongsTo(
                'App\Models\Category','category_id');
    }


}
