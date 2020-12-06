<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $table = 'vehicles';

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
}
