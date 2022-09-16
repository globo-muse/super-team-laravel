<?php

namespace App\Console;

use App\Jobs\OrderCompleteJob;
use App\Models\Order;
use App\Models\Video;
use App\Services\Vimeo\VimeoSlotService;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function(){
            $video = Video::query()->where('status', Video::STATUS_NO)->first();
            if(!$video) {
                info('NO VIDEOS');
                return;
            }
            $vimeoService = new VimeoSlotService();
            $vimeoResponse = $vimeoService->getInformations($video->vimeo_id);
            info("CronJob Start: #{$video->id} | {$video->vimeo_id} | {$vimeoResponse->getStatus()}");
            if($vimeoResponse->getStatus() === 'available') {
                $video->update(['status' => Video::STATUS_WAITING]);
            }

        })->everyMinute();

        $schedule->call(function(){
            $video = Video::query()->where('status', Video::STATUS_SENDED)->first();
            if(!$video) {
                info('NO VIDEOS - SENDED');
                return;
            }
            $vimeoService = new VimeoSlotService();
            $vimeoResponse = $vimeoService->getInformations($video->vimeo_id);
            info("SENDED CronJob Start: #{$video->id} | {$video->vimeo_id} | {$vimeoResponse->getStatus()}");
            if($vimeoResponse->getStatus() === 'available') {
                $video->update(['status' => Video::STATUS_COMPLETED]);
                $order = Order::query()->find($video->order_id);
                if(!$order) {
                    info('Problema Order não encontrada quando foi pra concluir o pedido');
                }
                info("Set Order #{$order->id} as completed");
                $order->update(['status' => 'completed']);
                OrderCompleteJob::dispatch($order);
            }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
