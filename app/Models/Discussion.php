<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discussion extends Model {

    protected $table = 'discussions';

    protected $fillable = [
        
    ];

    protected $hidden = [
        //
    ];

    public function getTicket(){
        return $this->belongsTo(
                'App\Models\Ticket','ticket_id');
    }


}
