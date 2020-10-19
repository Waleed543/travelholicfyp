<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    //This table stores the type of room
    protected $guarded = [];

    protected $table = 'rooms';

    public function facilities()
    {
        return $this->belongsToMany('App\Facility','rooms_facilities','room_id','facility_id','id','id');
    }
}
