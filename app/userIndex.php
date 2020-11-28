<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class userIndex extends Model
{
    public $userid;
    public $index;
    public function userIndex($userid,$index)
    {
        $this->userid=$userid;
        $this->index=$index;
    }

}
