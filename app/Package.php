<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use SoftDeletes;

    public function createdBy(){
        return $this->belongsTo(Admin::class, 'created_by')->withTrashed();
    }

    public function modifiedBy(){
        return $this->belongsTo(Admin::class, 'modified_by')->withTrashed();
    }

    public function subscribeUsers(){
        return $this->hasMany(SubscribePackage::class ,'package_id')
            ->where('payment_status', 'paid')
            ->groupBy('user_id');
    }
}
