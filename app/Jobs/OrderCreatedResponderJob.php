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

class OrderCreatedResponderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;



    /**
     * The order instance
     * 
     * @var App\Model\Order
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
        $user = User::find($this->order->responder_id);
        //TODO: remove hardcode
        SendgridService::send(
            'd-21084dda49704e889de11678df6b7998',
            $user->email,
            $user->name,
            OrderTemplateData::transform($this->order),
        );
    }
}
