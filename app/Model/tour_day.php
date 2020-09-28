<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class tour_day extends Model
{
    protected $table = 'tour_days';

    public function tour()
    {
        return $this->belongsTo('App\Tour','tour_id','id');
    }
}
