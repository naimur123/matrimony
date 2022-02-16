<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{
    use SoftDeletes;

    public function toUser(){
        return $this->belongsTo(User::class,'to_id');
    }

    public function fromUser(){
        return $this->belongsTo(User::class, 'from_id');
    }
}
