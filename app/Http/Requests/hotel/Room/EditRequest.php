<?php

namespace App\Http\Requests\Hotel\Room;

use App\Facility;
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'facilities' => 'required|array',
            'name'=>'required|string|regex:/^[a-zA-Z ]*$/',
            'total'=>'required|integer|gt:0',
            'beds'=>'required|integer|gt:0',
            'capacity'=>'required|integer|gt:0',
            'price'=>'required|integer|gt:0',
            'description'=>'required',
            'image'=>'image|nullable|max:1999'
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
        //create new facility
        if($this->facilities != null)
        {
            $i = 0;
            foreach ($this->facilities as $facility)
            {
                $facility = Facility::where('name',$facility)->first();

                if($facility != null)
                {
                    $temp[$i] = $facility->id;
                    $i++;
                }
                else{
                    $validator -> errors() -> add('facilities', 'Selected Facility is not correct');
                    break;
                }
            }
            $this->request->add(['facility'=>$temp]);
        }


    }
}
