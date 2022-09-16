<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\User;
use App\Services\Email\Sendgrid\SendgridService;
use App\Services\Email\Sendgrid\TemplateData\OrderTemplateData;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OrderCompleteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Instance os Order
     * @var Order
     */
    public Order $order;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        info(__CLASS__."{$this->order->email}, {$this->order->name}");
        //TODO: remove hardcode
        SendgridService::send(
            'd-449f46287a894f45b0b50d6d9182bf3e',
            $this->order->email,
            $this->order->name,
            OrderTemplateData::transform($this->order),
        );
    }
}
