<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public function notificationFrom(){
        return $this->belongsTo(User::class, 'from_user');
    }

    public function notificationTo(){
        return $this->belongsTo(User::class, 'to_user');
    }

    public function proposal(){
        return $this->belongsTo(Proposal::class, 'proposal_id');
    }
}
