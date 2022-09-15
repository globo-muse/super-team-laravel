<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use App\Services\OrderService;
use Database\Factories\OrderFactory;
use Exception;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\ExceptionWrapper;
use Tests\TestCase;

class OrderApiTest extends TestCase
{
    
    use RefreshDatabase;


    /**
     * @expectedException QueryException
     */
    public function test_order_service_withou_user_id()
    {
        $userResponder = User::factory()->make();
        $email = $userResponder->email;
        $dataInsert = [
            "responder_id" => $userResponder->id,
            "name" => $userResponder->name,
            "email" => $email,
            "occasion" => fake()->word(),
            "instructions" => fake()->text(20),
        ];
        $orderService = app(OrderService::class);
        $this->expectException(QueryException::class);
        $orderService->createOrder($dataInsert);
    }


    /**
     * @expectedException QueryException
     */
    public function test_order_service_create_order()
    {
        $userResponder = User::factory()->create();
        $user = User::factory()->create();
        $email = $user->email;
        $occasion = fake()->word();
        $dataInsert = [
            "responder_id" => $userResponder->id,
            "user_id" => $user->id,
            "name" => $user->name,
            "email" => $email,
            "occasion" => $occasion,
            "instructions" => fake()->text(20),
        ];
        $orderService = app(OrderService::class);
        $order = $orderService->createOrder($dataInsert);
        $this->assertModelExists($order);
        $this->assertEquals($user->id, $order->user->id);
        $this->assertEquals($email, $order->user->email);
    }


    public function test_list_order_by_user()
    {
        $totalOrder = 13;
        $user = User::factory()->create();
        $orders = Order::factory()->count($totalOrder)->create([
            'responder_id' => $user->id,
        ]);
        $orderService = app(OrderService::class);
        $orders = $orderService->getOrderByResponderId($user->id);
        $this->assertCount($totalOrder, $orders);
    }
}
