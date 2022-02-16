<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscribePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscribe_packages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('package_id');
            $table->date('activation_date');
            $table->date('expire_date');
            $table->double('payment_amount')->default(0);
            $table->double('paid_amount')->default(0);
            $table->string('tran_id')->nullable();
            $table->enum('payment_status',['paid','due','cancel','reject']);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('package_id')->references('id')->on('packages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscribe_packages');
    }
}
