<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{

    public function __construct(
        private Order $entity,
    ) {}


    public function getAllOrders()
    {
        return $this->entity->all();
    }


    public function createOrder(array $data)
    {
        return $this->entity->create($data);
    }


    public function getOrdersByResponserId($id)
    {
        return $this->entity->where('responder_id', $id)->get();
    }

    public function getOrderById($orderId)
    {
        return $this->entity->find($orderId);
    }
}
