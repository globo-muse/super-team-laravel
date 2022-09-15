<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\Video;
use App\Services\Vimeo\VimeoSlotService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class VimeoProcessingStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 10;


    private int $timeFaling = 0;

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
    * Calculate the number of seconds to wait before retrying the job.
    *
    * @return array
    */
    public function backoff()
    {
        return [5, 15, 30];
    }

    /**
     * Determine the time at which the job should timeout.
     *
     * @return \DateTime
     */
    public function retryUntil()
    {
        return now()->addSeconds(30);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $vimeoService = new VimeoSlotService();
        $vimeoResponse = $vimeoService->getInformations($this->video->vimeo_id);
        info(__LINE__ . " {$vimeoResponse->getStatus()}");
        if($vimeoResponse->getStatus() !== 'available') {
            info(__LINE__ . "Failing");
            $this->fail(new Exception('Video ainda nao está pronto', 501));
        }
        $this->order->status = 'completed';
    }

    /**
     * Handle a job failure.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function failed(Throwable $exception)
    {
        $this->timeFaling += 1;
        info(__CLASS__." Fail | Time:{$this->timeFaling}");
        // VimeoProcessingStatusJob::dispatch($this->order)->delay(now()->addSeconds(30));
    }
}
