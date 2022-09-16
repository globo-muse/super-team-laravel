<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Video>
 */
class VideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $order = Order::factory()->create();
        $vimeoHash = rand(1000000, 9999999);
        return [
            'order_id' => $order->id,
            'is_public' => true,
            'vimeo_id' => '/videos/' . $vimeoHash,
            'hash' => $vimeoHash,
            'thumb' => '',
            'link_play' => '',
            'status' => Video::STATUS_NO,
        ];
    }
}
