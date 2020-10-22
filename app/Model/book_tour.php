<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class book_tour extends Model
{
    protected $table = 'book_tour';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    public function tour()
    {
        return $this->belongsTo('App\Tour','tour_id','id');
    }
}
