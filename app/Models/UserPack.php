<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPack extends Model {

    protected $table = 'user_packs';

    protected $fillable = [
        
    ];

    protected $hidden = [
        //
    ];

    public function getPack(){
        return $this->belongsTo(
                'App\Models\Pack','pack_id');
    }


}
