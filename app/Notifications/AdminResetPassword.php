<?php

namespace App\Notifications;

use App\SystemInfo;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword as BaseResetPassword;

class AdminResetPassword extends BaseResetPassword
{
   

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if (static::$createUrlCallback) {
            $url = call_user_func(static::$createUrlCallback, $notifiable, $this->token);
        } else {
            $url = url(route('admin.password.reset', [
                'token' => $this->token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));
        }

        return (new MailMessage)
        ->view('email.accountNotification',[
            'email_body' => $this->getEmailValidationMesage($url)
        ]);
    }

    /**
     * Generate Email Validation Templete & Message
     */
    protected function getEmailValidationMesage($url){
        $system = SystemInfo::first();
        $message = 
            '<div>                
                <div>
                    <img src="'.asset($system->logo).'" style="height: 80px;">
                </div>
                <h3 style="margin: 0px 0px 10px 0px; color: #fff; font-size: 22px; background: #dd2476; padding: 5px 0px 5px 15px;">
                    Password Reset Email                    
                </h3>                
            </div>

            <!-- Body Content -->
            <div style="padding: 15px;">
                Dear User,<br><br>
                To Reset your password Click on Password Reset.<br><br>
                <a href="'.$url.'" style="background: rgb(0, 188, 213); color:#fff; padding:10px 20px; border-radius: 20px; text-decoration: none;">Password Reset</a><br><br>
                Thank you for choosing <a href="https://marriagematchbd.com/">Marriagematchbd.com</a><br>
            </div>';
        return $message;
    }

}
