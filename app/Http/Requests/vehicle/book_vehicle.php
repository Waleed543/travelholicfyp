<?php

namespace App\Http\Requests\vehicle;

use App\Enums\Payment;
use App\Vehicle;
use Carbon\CarbonPeriod;
use Illuminate\Foundation\Http\FormRequest;

class book_vehicle extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->vehicle = Vehicle::where('slug' , $this->route('slug'))->first();
        abort_if($this->vehicle == null,'404','Vehicle not found');
        $this->request->add(['tour'=>$this->vehicle]);
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'adults' => 'required|integer',
            'children' => 'required|integer',
            'departure_city'=>'required|integer|exists:city,id',
            'destination_city'=>'required|integer|exists:city,id',
            'departure_date'=>'required|date|after:today',
            'departure_time'=>'required|date_format:H:i',
            'returning_date'=>'required|date|after:today|after:departure_date',
            'returning_time'=>'required|date_format:H:i',
            'phone' => 'required|size:11',
            'payment_type' => 'required|gte:1|lte:1'
        ];
    }


    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $departure_date = new \Illuminate\Support\Carbon($this->input('departure_date'));
            $returning_date = new \Illuminate\Support\Carbon($this->input('returning_date'));
            $difference = ($departure_date->diff($returning_date)->days);
            //Check if nights to stay are greater than total day trip
            $this->request->add(['total_days'=>$difference]);

            if ($this->payment_type = 1)
            {
                $this->payment_type = Payment::EasyPaisa;
            }elseif($this->payment_type = 2)
            {
                $this->payment_type = Payment::Cash;
            }elseif($this->payment_type = 3){
                $this->payment_type = Payment::CreditCard;
            }else{
                $validator -> errors() -> add('payment_type', 'Error in Payment type field');
            }

            //Check if destination and departure cities are same
            if($this->input('departure_city') == $this->input('destination_city')){
                $validator -> errors() -> add('departure_city', 'Departure and destination city cannot be same');
            }
            //Check if destination date is after returning date
            if($departure_date->gt($returning_date)){
                $validator -> errors() -> add('departure_date', 'Returning date should be after Destination date');
                return back()->withErrors($validator);
            }


            $bookings = $this->vehicle->bookings()->orderBy('departure_date','asc')->where('status','=','Booked')->get();

            $previous_dates = array();
            foreach ($bookings as $book)
            {
                $period = CarbonPeriod::create($book->departure_date, $book->returning_date);

                // Convert the period to an array of dates
                $dates = $period->toArray();
                // Iterate over the period
                foreach ($dates as $date) {
                    $date = $date->format('d-m-Y');
                    array_push($previous_dates,$date);
                }

            }

            $period = CarbonPeriod::create($departure_date, $returning_date);

            $booking_dates = [];
            // Convert the period to an array of dates
            $dates = $period->toArray();
            // Iterate over the period
            foreach ($dates as $date) {
                $date = $date->format('d-m-Y');
                array_push($booking_dates,$date);
            }


            $result=array_intersect($booking_dates,$previous_dates);

            //Check if destination date is after returning date
            if($result != null){
                $validator -> errors() -> add('departure_date', 'This vehicle is already booked in these dates');
                return back()->withErrors($validator);
            }

        });

    }
}
