<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscribePackage extends Model
{
    public function packageDetails(){
        return $this->hasOne(SubscribePackageDetails::class, 'subscribe_package_id');
    }

    public function package(){
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function paymentTransaction(){
        return $this->hasOne(PaymentTransactionDetails::class, 'tran_id', 'tran_id');
    }
}
