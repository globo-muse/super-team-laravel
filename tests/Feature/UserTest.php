<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Support\Str;

use function PHPUnit\Framework\assertCount;

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


    public function test_user_service_get_user_by_id()
    {
        $email = 'emailtest@teste.com';
        $user = User::factory()->create([
            'email' => $email,
        ]);
        $userService = new UserService();
        $userCaught = $userService->getUserByEmail($email);
        $this->assertEquals($email, $userCaught->email);
    }

    // public function test_service_user_update_informations()
    // {
    //     $image = 'user/test/image.jpg';
        
    //     $name = 'Teste 001';
    //     $email = 'emaildetest@test.com';

    //     $user = User::factory()->create([
    //         'image' => $image,
    //     ]);

    //     $userService = new UserService();
    //     $userService->userUpdate([
    //         'name' => $name,
    //         'email' => $email,
    //         'image' => fake()->image(storage_path('users')),
    //     ]);

    //     $userUpdated = $userService->getUserByEmail($email);

    //     $this->assertEquals($email, $userUpdated->email);

    // }


    // public function test_forgot_password_generate_token()
    // {
    //     $user = User::factory()->create();
    //     $dataJson = [
    //         'email' => $user->email,
    //     ];
    //     $response = $this->postJson(route('password.email'), $dataJson);
    //     $dataPasswordReset = DB::table('password_resets')->where('email', $user->email)->get();
    //     // dd(strlen($dataPasswordReset[0]->token));
    //     $this->assertCount(1, $dataPasswordReset);
    //     $this->assertEquals(60, strlen($dataPasswordReset[0]->token));
    //     $response->assertStatus(200);
    // }


    // public function test_forgot_password_check_reseted_password()
    // {
    //     $user = User::factory()->create();
    //     $email = $user->email;
    //     $token = $token = Str::random(64);
    //     DB::table('password_resets')->insert([
    //         'email' => $email, 
    //         'token' => $token, 
    //         'created_at' => Carbon::now()
    //     ]);
    // }
}
