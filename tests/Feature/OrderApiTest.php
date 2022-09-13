<?php

namespace Tests\Feature;

use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_creating_order()
    {
        $user = User::factory()->create();
        $response = $this->postJson(
            route('api.collaborators.list'),
            [
                'product_id' => $user->id,
            ]
        );
        $response->assertStatus(200);
    }
}
