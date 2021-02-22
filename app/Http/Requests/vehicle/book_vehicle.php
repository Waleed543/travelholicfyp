<?php

namespace App\Http\Requests\vehicle;

use App\Vehicle;
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
        abort_if($this->vehicle == null,'404','Tour not found');
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
            'returning_date'=>'required|date|after:today',
            'returning_time'=>'required|date_format:H:i',
            'phone' => 'required|size:11',
            'payment_type' => 'required|gte:1|lte:2'
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

            //Check if destination and departure cities are same
            if($this->input('departure_city') == $this->input('destination_city')){
                $validator -> errors() -> add('departure_city', 'Departure and destination city cannot be same');
            }




        });

    }
}
