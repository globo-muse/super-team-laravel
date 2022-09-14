<?php

namespace App\Services\Email\Sendgrid\TemplateData;

use App\Models\Order;

class OrderTemplateData
{
    static public function transform(Order $order)
    {
        return [
            "customer_name" => $order->name,
            "responder_name" => $order->responder->name,
            "order_id" => $order->id,
            "to_name" => $order->name,
            "occasion" => $order->occasion,
            "instructions" => $order->instructions,
            "frontend_url" => getenv('FRONTEND_APP_URL'),
        ];
    }
}
