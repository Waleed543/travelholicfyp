<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $table = 'hotels';

    public function tags()
    {
        return $this->belongsToMany('App\Tag','tags_hotel','hotel_id','tag_id','id','id');
    }
    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    public function rooms()
    {
        return $this->hasMany('App\Room','hotel_id','id');
    }

    public function booking()
    {
        return $this->hasMany('App\Model\book_hotel','hotel_id','id');
    }
}
