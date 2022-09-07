<?php

namespace App\Repositories\Contracts;

interface OrderRepositoryInterface
{
    public function getAllOrders();
    public function getOrdersByResponserId(int $id);
    public function createOrder(array $data);
}