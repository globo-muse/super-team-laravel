<?php

namespace App\Http\Requests;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateVimeoSlotRequest extends FormRequest
{

    /**
     * Instanco of a Order to dont need get in DB againt
     * 
     * @var App\Model\Order
     */
    public Order $order;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(Order $order)
    {
        $order = $order->find($this->id);
        $user = $this->user();

        if(!$order) {
            return false;
        }

        if($order->responder_id !== $user->id) {
            return false;
        }
        $this->order = $order;
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
