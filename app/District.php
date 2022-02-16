<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    public function divisions(){
        $this->belongsTo(Division::class, 'division_id');
    }

    public function upozila(){
        $this->hasMany(Upozila::class, 'district_id');
    }
}
