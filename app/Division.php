<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    public function districts(){
        $this->hasMany(District::class,'division_id');
    }
}
