<?php

namespace App\Http\Requests\Tour;

use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {

        if($this->tags != null)
        {
            $this->merge([
                'tags' => explode(",",$this->tags),
            ]);

        }

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tags' => 'nullable|array',
            'tags.*' => 'regex:/^[a-zA-Z ]*$/',
            'name'=>'required|string|regex:/^[a-zA-Z ]*$/',
            'departure_city'=>'required|integer|exists:city,id',
            'destination_city'=>'required|integer|exists:city,id',
            'departure_date'=>'required|date|after:today',
            'departure_time'=>'required|date_format:H:i',
            'returning_date'=>'required|date|after:today',
            'returning_time'=>'required|date_format:H:i',
            'nights_to_stay'=>'required|integer|gt:0',
            'total_seats'=>'required|integer|gt:0',
            'description'=>'required',
            'price'=>'required|integer|gt:0',
            'image'=>'image|max:1999'
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
            if ($this->input('nights_to_stay')>= $difference) {
                $validator -> errors() -> add('nights_to_stay', 'No of nights to stay should be greater than total days');
            }

            //Check if destination and departure cities are same
            if($this->input('departure_city') == $this->input('destination_city')){
                $validator -> errors() -> add('departure_city', 'Departure and destination city cannot be same');
            }


        });

    }
}
