<?php

namespace App\Http\Controllers;


use App\Enums\Status;
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
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
            $jaccard=new RecommendorController();
=======

>>>>>>> parent of 8cadabb... recommender changes

            if($user->id!=$otheruser->id)
            {
                $newuser= new userIndex();
                $temp=$this->jaccard($user,$otheruser);
                $newuser->index=$temp;
                $newuser->userid=$otheruser->id;
                $otherusers[$i]=$newuser;
                $i++;

            }


        }
        self::$matrix[$user->id]=$otherusers;

    }




}

public function GetRecommendationTour()
{
<<<<<<< HEAD


    RecommendorController::TourRecommendor();
=======
    $userid=2;
    self::TourRecommendor();
>>>>>>> parent of 8cadabb... recommender changes
    $temp=self::$matrix[$userid];
    $TopSimilar=collect([]);
    for($i=0;$i<5;$i++)
    {
        $usr=new userIndex();
        $usr->userid=null;
        $usr->index=0.0;
        $TopSimilar->push($usr);
    }
=======

            if($user->id!=$otheruser->id)
            {
                $otherusers[$otheruser->id]=$this->jaccard();




>>>>>>> parent of fd444e4... tour recommender

            }


<<<<<<< HEAD
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
=======
>>>>>>> parent of fd444e4... tour recommender
=======

            if($user->id!=$otheruser->id)
            {
                $otherusers[$otheruser->id]=$this->jaccard();





            }


>>>>>>> parent of fd444e4... tour recommender
        }
        self::$matrix[$user->id]=$otherusers;

    }
    dd(self::$matrix);

    if($recommendations->count()<2)
    {
        $tours = Tour::with('user')->where('status','=',Status::Active)
            ->orderBy('created_at','desc')->limit(4)->get();
        $j=0;
        $x=0;
        $max=count($tours);
        $k=0;
        for($i=$recommendations->count();$i<2;$i++)
        {

<<<<<<< HEAD

            foreach ($recommendations as $recommendation)
            {
=======
>>>>>>> parent of fd444e4... tour recommender

                if($recommendation->id==$tours[$j]->id)
                {
                    $x=1;
                    break;
                }
            }

            if($x==0) {

<<<<<<< HEAD
                $recommendations->push($tours[$j]);
            }
            else
            {
                $i--;
            }
            $j++;
            $x=0;
            $k++;
            if($k>=$max)
            {
                break;
            }
        }
    }



}


=======
>>>>>>> parent of fd444e4... tour recommender
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
