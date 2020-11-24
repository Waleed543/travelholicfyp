<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class book_hotel extends Model
{
    protected $table = 'book_hotel';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    public function hotel()
    {
        return $this->belongsTo('App\Hotel','hotel_id','id');
    }

    public function room()
    {
        return $this->belongsTo('App\Room','room_id','id');
    }
}
