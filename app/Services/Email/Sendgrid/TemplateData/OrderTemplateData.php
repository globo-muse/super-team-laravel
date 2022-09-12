<?php

namespace App\Services\Email\Sendgrid\TemplateData;

use App\Models\Order;

class OrderTemplateData
{
    static public function transform(Order $order)
    {
        return [
            "customer_name" => $order->name,
            "order_id" => $order->id,
            "to_name" => $order->name,
            "occasion" => $order->occasion,
            "instructions" => $order->instructions,
        ];
    }
}