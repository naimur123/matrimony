<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proposal_sent_from');
            $table->unsignedBigInteger('proposal_sent_to');
            $table->enum('status',['accept','reject','pending'])->default('pending');
            $table->timestamps();
            $table->foreign('proposal_sent_from')->references('id')->on('users');
            $table->foreign('proposal_sent_to')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proposals');
    }
}
