<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $table = 'facilities';

    protected $guarded = [];

    public function rooms(){
        return $this->belongsToMany('App\Room','rooms_facilities','room_id','facility_id','id','id');
    }
}
