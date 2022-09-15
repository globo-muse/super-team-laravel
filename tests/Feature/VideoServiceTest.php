<?php

namespace Tests\Feature;

use App\Models\Video;
use App\Services\VideoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VideoServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 
     *
     * @return void
     */
    public function test_video_service_return_any_video()
    {
        $video = Video::factory()->create();
        $this->assertModelExists($video);
    }

    public function test_video_service_return_with_status_logoable()
    {
        Video::factory()->count(3)->create(
            ['status' => 'open']
        );

        Video::factory()->count(5)->create(
            ['status' => 'logoable']
        );

        $videoService = App(VideoService::class);
        $videosLogoable = $videoService->getVideoLogoable();

        $this->assertCount(5, $videosLogoable);
    }
}
