<?php

namespace App\Http\Requests\Hotel;

use App\Hotel;
use Illuminate\Foundation\Http\FormRequest;

class book_hotel extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->hotel = Hotel::where('slug' , $this->route('slug'))->first();
        abort_if($this->hotel == null,'404','Hotel not found');
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
            'adults' => 'required|integer',
            'children' => 'required|integer',
            'total_rooms' => 'required|integer',
            'check_in_date'=>'required|date|after:today',
            'check_out_date'=>'required|date|after:today',
        ];
    }
}
