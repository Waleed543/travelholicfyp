<?php

namespace App\Http\Requests\hotel;

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

    function prepareForValidation()
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
            'total_rooms'=>'required|integer|gt:0',
            'city'=>'required',
            'description'=>'required',
            'price'=>'required|integer|gt:0',
            'image'=>'image|required|max:1999'
            //
        ];
    }
}
