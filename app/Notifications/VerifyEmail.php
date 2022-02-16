<?php

namespace App\Notifications;

use App\SystemInfo;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailBase;
use Illuminate\Support\Facades\Auth;

class VerifyEmail extends VerifyEmailBase
{
    
    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)    {
        return (new MailMessage)->view('email.accountNotification',[
            'email_body' => $this->getEmailValidationMesage($notifiable)
        ]);
    }

    /**
     * Generate Email Validation Templete & Message
     */
    protected function getEmailValidationMesage($user){
        $system = SystemInfo::first();
        $message = 
            '<div>                
                <div>
                    <img src="'.asset($system->logo).'" style="height: 80px;">
                </div>
                <h3 style="margin: 0px 0px 10px 0px; color: #fff; font-size: 22px; background: #dd2476; padding: 5px 0px 5px 15px;">
                    Verify your Email Address                    
                </h3>                
            </div>

            <!-- Body Content -->
            <div style="padding: 15px;">
                Hi '. $user->first_name.',<br><br>
                Thank you for choosing <a href="https://marriagematchbd.com/">Marriagematchbd.com</a><br>
                To make  <a href="https://marriagematchbd.com/">Marriagematchbd.com</a>  safe for its users, we require all our users to verify their email IDs.<br><br>
                <a href="'.$this->verificationUrl($user).'" style="background: rgb(0, 188, 213); color:#fff; padding:10px 20px; border-radius: 20px; text-decoration: none;">Verify Email</a>
                <br><br>
                <p style="color:#aaaaaa;font-size:14px;">Note: You may stop receiving emails & will not be able to access your Profile if you don\'t verify your email ID.</p>
            </div>';
        return $message;
    }

}
