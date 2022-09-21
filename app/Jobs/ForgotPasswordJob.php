<?php

namespace App\Jobs;

use App\Services\Email\Sendgrid\SendgridService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(protected string $email, protected string $newPassword)
    {}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //TODO: remove hardcode
        //TODO: Set a correct TemplateID
        SendgridService::send(
            'd-2760a485df154b2a857cde3b91645594',
            $this->email,
            '',
            [
                'new_password' => $this->newPassword,
                'frontend_url' => getenv('FRONTEND_APP_URL') . '/login',
            ],
        );
    }
}
