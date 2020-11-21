<?php

namespace App\Http\Controllers;


use App\Model\book_hotel;
use App\User;
use App\Model\book_tour;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Collection;

class RecommendorController extends Controller
{
    public static $matrix;

    public function TourRecommendor()
{
    self::$matrix=collect([]);
    $users = User::all();

    foreach ($users as $user)
    {

        $otherusers = collect([]);
        foreach ($users as $otheruser)
        {

            if($user->id!=$otheruser->id)
            {
                $otherusers[$otheruser->id]=$this->jaccard();





            }


        }
        self::$matrix[$user->id]=$otherusers;

    }
    dd(self::$matrix);



}


public function jaccard()
{
    $user1= User::where('id' , 2)->get();
    $user1=$user1[0];
    $user2=$user1;
    $bookings1=$user1->book_tour()->get();
    $bookings2=$bookings1;
    $AintB=0;
    $A=count($bookings1);
    $B=count($bookings2);
    foreach ($bookings1 as $booking)
    {
        if($booking['user_id']=$user2->id)
        {
            $AintB++;
        }
    }

    return $AintB/($A+$B-$AintB);


}

}
