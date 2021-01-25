<?php

namespace App\Http\Controllers;


use App\Enums\Status;
use App\Model\book_hotel;
use App\Tour;
use App\userIndex;
use App\User;
use App\Model\book_tour;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Collection;

class RecommendorController extends Controller
{
    public static $matrix;

    public static function TourRecommendor()
{
    self::$matrix=collect([]);
    $users = User::all();


    foreach ($users as $user)
    {
        $i=0;

        $otherusers = collect([]);
        foreach ($users as $otheruser)
        {
            $jaccard=new RecommendorController();

            if($user->id!=$otheruser->id)
            {
                $newuser= new userIndex();
                $temp=$jaccard->jaccard($user,$otheruser);
                $newuser->index=$temp;
                $newuser->userid=$otheruser->id;
                $otherusers[$i]=$newuser;
                $i++;

            }


        }
        self::$matrix[$user->id]=$otherusers;


    }





}

public function GetRecommendationTour($userid)
{


    RecommendorController::TourRecommendor();
    $temp=self::$matrix[$userid];
    $TopSimilar=collect([]);
    for($i=0;$i<5;$i++)
    {
        $usr=new userIndex();
        $usr->userid=null;
        $usr->index=0.0;
        $TopSimilar->push($usr);
    }

    foreach ($temp as $tempp)
    {
        if($tempp->index>$TopSimilar->min('index'))
        {
            $TopSimilar->push($tempp);
            $TopSimilar=$TopSimilar->sortByDesc('index');

            $TopSimilar->pop();
        }

    }

    $mainuser=User::where('id',$userid)->first();
    $mainbookings=$mainuser->book_tour;

    $recommendations= collect([]);

    foreach ($TopSimilar as $Top)
    {

        if($Top->userid!=null) {

            $User = User::where('id', $Top->userid)->first();
            $bookings = $User->book_tour;

            foreach ($bookings as $booking) {

                $add = 0;
                foreach ($mainbookings as $mainbooking) {
                    if ($booking->tour_id == $mainbooking->tour_id) {
                        $add = 0;
                        break;
                    } else {
                        $add = 1;
                    }
                }
                if ($recommendations->count() < 2) {
                    if ($add == 1) {
                        $temptour=Tour::where('id',$booking->tour_id)->first();
                        $recommendations->push($temptour);
                    }
                } else {
                    break;
                }
            }
            if ($recommendations->count() >= 2) {
                break;
            }
        }

    }

    if($recommendations->count()<2)
    {

        $tours = Tour::with('user')->where('status','=',Status::Active)
            ->orderBy('created_at','desc')->limit(4)->get();
        $j=0;
        $x=0;

        $max=count($tours);
        if($max!=0) {
            $k = 0;
            for ($i = $recommendations->count(); $i < 2; $i++) {


                foreach ($recommendations as $recommendation) {


                    if ($recommendation->id == $tours[$j]->id) {
                        $x = 1;
                        break;
                    }
                }

                if ($x == 0) {

                    $recommendations->push($tours[$j]);
                } else {
                    $i--;
                }
                $j++;
                $x = 0;
                $k++;
                if ($k >= $max) {
                    break;
                }
            }
        }
    }


return $recommendations;


}



public function jaccard($user1,$user2)
{

    $bookings1=$user1->book_tour()->get();
    $bookings2=$user2->book_tour()->get();
    $AintB=0;
    $A=count($bookings1);
    $B=count($bookings2);

    foreach ($bookings1 as $booking)
    {
        foreach ($bookings2 as $booking2)
        {
            if($booking->tour_id==$booking2->tour_id)
            {
                $AintB++;
                break;
            }
        }
    }
    $sum=$A+$B-$AintB;


    return $sum == 0 ? 0.0 :floatval($AintB/$sum);


}

}
