<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\Video;
use App\Services\Vimeo\VimeoSlotService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class VimeoProcessingStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * Insntance of a Order
     * 
     * @var App\Models\Order
     */
    private Order $order;

    /**
     * A instance of a Video
     * 
     * @var App\Models\Video
     */
    private Video $video;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->video = $order->video;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $vimeoService = new VimeoSlotService();
        dd($vimeoService->getInformations($this->video->vimeo_id));
    }
}
