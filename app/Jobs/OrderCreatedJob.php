<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\User;
use App\Services\Email\Sendgrid\SendgridService;
use App\Services\Email\Sendgrid\TemplateData\OrderTemplateData;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OrderCreatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

        /**
     * The order instance
     * 
     * @var \App\Models\Order
     */
    public Order $order;


    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 10;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order->withoutRelations();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $user = User::find($this->order->responder_id);
        //TODO: remove hardcode
        SendgridService::send(
            'd-7adbcca8296e499db3f9b3b245d6750d',
            $this->order->email,
            $this->order->name,
            OrderTemplateData::transform($this->order),
        );
    }
}
