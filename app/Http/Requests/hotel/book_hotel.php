<?php

namespace App\Http\Requests\Hotel;

use App\Enums\Payment;
use App\Hotel;
use App\Room;
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
        
        $this->room = Room::where('slug','=',$this->route('room_slug'))->where('hotel_id',$this->hotel->id)->first();
        
        $this->request->add(['room'=>$this->room]);
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
            'total_rooms' => 'required|integer|gte:1',
            'check_in_date'=>'required|date|after:today',
            'check_out_date'=>'required|date|after:today',
            'payment_type' => 'required|gte:1|lte:1'
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
                $validator -> errors() -> add('payment_type', 'Please select a valid payment type');
            }
            if($this->room->available < $this->total_rooms)
            {
                $validator -> errors() -> add('total_rooms', 'There are not enough rooms');
            }

            if($this->room->capacity*$this->total_rooms < $this->adults+$this->children)
            {
                $validator -> errors() -> add('total_rooms', 'Only '.$this->room->capacity.' persons allowed per room');
            }
            
            
        });

    }
}
