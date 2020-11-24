<?php

namespace App\Http\Requests\Hotel;

use App\Enums\Payment;
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
        $this->request->add(['hotel'=>$this->hotel]);
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
    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->payment_type = 1)
            {
                $this->payment_type = Payment::EasyPaisa;
                //$this->request->add(['payment_type'=>$this->tour]);
            }elseif($this->payment_type = 2)
            {
                $this->payment_type = Payment::Cash;
            }elseif($this->payment_type = 3){
                $this->payment_type = Payment::CreditCard;
            }else{
                $validator -> errors() -> add('payment_type', 'Error in Payment type field');
            }
        });

    }
}
