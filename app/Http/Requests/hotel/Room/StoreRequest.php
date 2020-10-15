<?php

namespace App\Http\Requests\Hotel\Room;

use App\Hotel;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'facilities.*' => 'regex:/^[a-zA-Z ]*$/|exists:facilities,name',
            'name'=>'required|string|regex:/^[a-zA-Z ]*$/',
            'total'=>'required|integer|gt:0',
            'price'=>'required|integer|gt:0',
            'description'=>'required',
            'image'=>'image|required|max:1999'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'facilities.*.exists' => 'This Facility Does Not Exists',
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
            //
        });

    }
}
