<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Upozila extends Model
{
    public function upozila(){
        $this->belongsTo(District::class, 'district_id');
    }
}
