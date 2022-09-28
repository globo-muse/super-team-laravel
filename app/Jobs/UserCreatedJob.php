<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\Email\Sendgrid\SendgridService;
use App\Services\Email\Sendgrid\TemplateData\UserCreatedTemplateData;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UserCreatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public User $user, public string $password)
    {}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //TODO: remove hard code
        SendgridService::send(
            'd-ab16489b51f84b6a861ca5b15e3b089b',
            $this->user->email,
            $this->user->name,
            UserCreatedTemplateData::transform($this->user, $this->password),
        );
    }
}
