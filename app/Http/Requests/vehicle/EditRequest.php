<?php

namespace App\Http\Requests\vehicle;

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
            'make'=>'required|string|regex:/^[a-zA-Z ]*$/',
            'model'=>'required|string|regex:/^[a-zA-Z ]*$/',
            'color'=>'required|string|regex:/^[a-zA-Z ]*$/',
            'year'=>'required|date_format:Y',
            'condition'=>'required|integer',
            'mileage'=>'required|integer',
            'vinumber'=>'required|integer',
            'price'=>'required|integer|gt:0',
            'city'=>'required|integer|exists:city,id',
            'description'=>'required',
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
            $current_year = (int)date('Y');

            if ($this->input('year') > $current_year or $this->input('year') < 1900) {
                $validator -> errors() -> add('year', 'Please enter a valid year');
            }

        });

    }
}
