<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

use Mail;
use App\Mail\UserPasswordMail;

class AddUserJob implements ShouldQueue
{
    use Queueable;

    private $user;
    private $password;

    /**
     * Create a new job instance.
     */
    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->user->email)
            ->send(new UserPasswordMail($this->user, $this->password));
    }
}
