<?php

namespace Tests\Feature;

use App\Models\Video;
use App\Services\VideoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class VideoServiceTest extends TestCase
{
    use RefreshDatabase;

    public VideoService $videoService;

    protected function setUp() : void
    {
        parent::setUp();
        $this->videoService = App(VideoService::class);
    }

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


    public function test_video_service_get_video_by_id()
    {
        $video = Video::factory()->create();
        $videoFromService = $this->videoService->getVideoById($video->id);
        $this->assertEquals($video->id, $videoFromService->id);
    }


    public function test_video_service_return_with_status_logoable()
    {
        Video::factory()->count(3)->create(
            ['status' => Video::STATUS_NO]
        );

        Video::factory()->count(5)->create(
            ['status' => Video::STATUS_WAITING]
        );

        // $videoService = 
        $videosLogoable = $this->videoService->getVideoLogoable();

        $this->assertCount(5, $videosLogoable);
    }


    public function test_video_service_set_status()
    {
        $video = Video::factory()->create(
            ['status' => Video::STATUS_WAITING]
        );
        $status = Video::STATUS_SENDED;
        $this->videoService->setVideoStatus($video, $status);
        
        $videoNewStatus = Video::query()->find($video->id);
        $this->assertEquals($status, $videoNewStatus->status);
    }
}
