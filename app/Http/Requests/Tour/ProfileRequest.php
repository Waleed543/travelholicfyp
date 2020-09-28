<?php

namespace App\Http\Requests\Tour;

use App\Tour;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    protected $tour = null;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->tour = Tour::where('slug' , $this->route('slug'))->first();
        abort_if($this->tour == null,'404','Tour not found');
        $this->request->add(['tour'=>$this->tour]);
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
            //
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

            $departure_date = new \Illuminate\Support\Carbon( $this->tour->departure_date);
            $returning_date = new \Illuminate\Support\Carbon( $this->tour->returning_date);
            $days = ($departure_date->diff($returning_date)->days);

            $this->request->add(['days'=>$days]);

            for ($i = 1; $i <= $days; $i++)
            {
                if (!$this->filled("day-".$i))
                {
                    $validator -> errors() -> add("day-".$i, 'Day-'.$i.' not present');
                }
            }


        });

    }
}
