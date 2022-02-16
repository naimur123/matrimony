<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentTransactionDetails extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id','tran_id','val_id','amount','card_type','store_amount','card_no','bank_tran_id',
        'status','tran_date','error','currency','card_issuer','card_brand','card_sub_brand',
        'card_issuer_country','card_issuer_country_code','currency_type','currency_amount'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
