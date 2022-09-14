<?php

namespace App\Services;

use App\Repositories\Contracts\OrderRepositoryInterface;

class OrderService
{
    public function __construct(
        private OrderRepositoryInterface $repository
    ){}


    public function getAllOrders()
    {
        return $this->repository->getAllOrders();
    }


    public function createOrder(array $data)
    {
        return $this->repository->createOrder($data);
    }


    public function getOrderByResponderId($id)
    {
        return $this->repository->getOrdersByResponserId($id);
    }

    public function getOrderById($id)
    {
        return $this->repository->getOrderById($id);
    }
}
