<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    public function proposalFrom(){
        return $this->belongsTo(User::class, 'proposal_sent_from');
    }

    public function proposalTo(){
        return $this->belongsTo(User::class, 'proposal_sent_to');
    }
}
