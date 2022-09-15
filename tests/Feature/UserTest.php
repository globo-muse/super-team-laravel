<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_instance_user_model()
    {
        $user = User::factory()->create();
        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }


    public function test_another_instance_of_user()
    {
        $totalUsers = 100;
        $user = User::factory($totalUsers)->create();
        $this->assertDatabaseCount('users', $totalUsers);
    }

    public function  test_user_auth_endpoint()
    {
        $user = User::factory()->create([
            'password' => bcrypt('123456'),
        ]);
        $response = $this->postJson(route('user.auth'), [
            'email' => $user->email, 
            'password' => '123456',
            'device_name' => 'test_laravel'
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure(['token']);

    }
}
