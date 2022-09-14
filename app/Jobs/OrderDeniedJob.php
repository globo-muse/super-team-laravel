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
use Illuminate\Queue\Middleware\ThrottlesExceptions;
use Illuminate\Queue\SerializesModels;

class OrderDeniedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * Instence of Order
     * 
     * @var \App\Models\Order
     */
    private Order $order;

    /**
     * Instance of User represente a responder with video
     * 
     * @var \App\Models\User
     */
    private User $responder;

    /**
     * Get the middleware the job should pass through.
     *
     * @return array
     */
    public function middleware()
    {
        return [new ThrottlesExceptions(10, 5)];
    }

    /**
    * Determine the time at which the job should timeout.
    *
    * @return \DateTime
    */
    public function retryUntil()
    {
        return now()->addMinutes(5);
    }

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->user = (new User())->find($order->user_id);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $dynamicTemplateData = OrderTemplateData::transform($this->order);
        $dynamicTemplateData['frontend_url'] = getenv('FRONTEND_APP_URL');
        //TODO: remove hardcode
        SendgridService::send(
            'd-2760a485df154b2a857cde3b91645594',
            $this->order->email,
            $this->order->name,
            $dynamicTemplateData,
        );
    }
}
