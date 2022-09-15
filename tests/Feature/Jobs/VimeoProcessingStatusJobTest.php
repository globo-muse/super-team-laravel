<?php

namespace Tests\Feature\Jobs;

use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VimeoProcessingStatusJobTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        // dd(Order::factory(1)->make());
        $this->assertFalse(false);
    }
}
