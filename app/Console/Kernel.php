<?php

namespace App\Console;

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
        // $schedule->command('inspire')->hourly();
        $schedule->call(function(){
            // $video = DB::table('videos')->where('status', 'sended')->first();
            $video = Video::query()->where('status', 'sended')->first();
            $vimeoService = new VimeoSlotService();
            $vimeoResponse = $vimeoService->getInformations($video->vimeo_id);
            info("CronJob Start: #{$video->id} | {$video->vimeo_id} | {$vimeoResponse->getStatus()}");
            if($vimeoResponse->getStatus() === 'available') {
                $video->update(['status' => 'logoable']);
                // $video->status = 'logoable';
                // $video->save();
                // $order = DB::table('orders')->find($video->order_id);
                // $order->update(['status' => 'completed']);
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
