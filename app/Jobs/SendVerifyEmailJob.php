<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

use Mail;
use App\Mail\VerifyEmailMail;

class SendVerifyEmailJob implements ShouldQueue
{
    use Queueable;

    public $name;
    public $email;
    public $verification_code;

    /**
     * Create a new job instance.
     */
    public function __construct($name, $email, $verification_code)
    {
        $this->name = $name;
        $this->email = $email;
        $this->verification_code = $verification_code;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)
            ->send(new VerifyEmailMail($this->name, $this->verification_code));
    }
}
