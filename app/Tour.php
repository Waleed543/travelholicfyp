<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tour extends Model
{
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    public function tour_days()
    {
        return $this->hasMany('App\Model\tour_day','tour_id','id');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag','tags_tour','tour_id','tag_id','id','id');
    }

    public function bookings()
    {
        return $this->hasMany('App\Model\book_tour','tour_id','id');
    }
}
