<?php

namespace App;

use App\Notifications\AdminResetPassword;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Send the Password Reset Email
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPassword($token));
    }
}
