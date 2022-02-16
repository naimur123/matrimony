<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTransactionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_transaction_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('tran_id');
            $table->string('val_id');
            $table->double('amount');            
            $table->string('card_type')->nullable();
            $table->double('store_amount');
            $table->string('card_no')->nullable();
            $table->string('bank_tran_id')->nullable();
            $table->string('status');
            $table->datetime('tran_date');
            $table->string('error')->nullable();
            $table->string('currency')->nullable();
            $table->string('card_issuer')->nullable();
            $table->string('card_brand')->nullable();
            $table->string('card_sub_brand')->nullable();
            $table->string('card_issuer_country')->nullable();
            $table->string('card_issuer_country_code')->nullable();
            $table->string('currency_type')->nullable();
            $table->double('currency_amount')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_transaction_details');
    }
}
