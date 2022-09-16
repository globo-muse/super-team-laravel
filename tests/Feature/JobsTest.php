<?php

namespace Tests\Feature;

use App\Jobs\OrderCreatedJob;
use App\Jobs\OrderCreatedResponderJob;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class JobsTest extends TestCase
{
    use RefreshDatabase;

    public function test_example()
    {
        $order = Order::factory()->create([
            'name' => 'Rodolfo',
            'email' => 'gorgonneto@gmail.com',
        ]);
        $order->responder->name = 'Gorgon Neto';
        $order->responder->email = 'gorgonneto@gmail.com';

        OrderCreatedJob::dispatch($order);
        OrderCreatedResponderJob::dispatch($order);
        $this->assertEquals(true, true);
    }
}
