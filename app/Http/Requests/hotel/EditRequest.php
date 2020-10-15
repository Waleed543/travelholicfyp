<?php

namespace App\Http\Requests\Hotel;

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
            'city'=>'required',
            'description'=>'required',
            'image'=>'image|max:1999'
        ];
    }
}
