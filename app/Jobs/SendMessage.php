<?php

namespace App\Jobs;

use App\Notifications\AccountNotification;
use App\SystemInfo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class SendMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->sendMail();
    }

    /**
     * Send E-Mail Function
     */
    protected function sendMail(){
        $system = SystemInfo::first();
        $data = $this->data;
        Notification::send($system, new AccountNotification('Customer Support Email', $this->getMessage($system, $data)) );
    }

    /**
     * Render Message
     */
    protected function getMessage($system, $data){
        $message = '
            <div>                
                <div>
                    <img src="'.asset($system->logo).'" style="height: 80px;">
                </div>
                <h3 style="margin: 0px 0px 10px 0px; color: #fff; font-size: 22px; background: #dd2476; padding: 5px 0px 5px 15px;">
                    '.$data['name'].' sent a message.                    
                </h3>                
            </div>

            <!-- Body Content -->
            <div style="padding: 15px;">
                Sender Name : '.$data['name'].'<br>
                Sender Email: '.$data['email'].'<br>
                Sender Phone Number : '. (is_null($data['phone']) ? 'N/A' : $data['phone'] ).'<br><br>
                Message :'. $data['message'] .'
            </div>
        ';
        return $message;
    }
}
