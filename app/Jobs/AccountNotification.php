<?php

namespace App\Jobs;

use App\Notifications\AccountNotification as NotificationsAccountNotification;
use App\SystemInfo;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class AccountNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $to_email;
    protected $subject;
    protected $message;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($to_email, $subject, $message)
    {
        $this->to_email = $to_email;
        $this->subject = $subject;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = User::where('email', $this->to_email)->first();
        Notification::send($user, new NotificationsAccountNotification($this->subject, $this->message) );
    }
}
