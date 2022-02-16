<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();            
            $table->unsignedBigInteger('from_user')->nullable();
            $table->unsignedBigInteger('to_user');
            $table->unsignedBigInteger('profile_visitor_id')->nullable();            
            $table->unsignedBigInteger('proposal_id')->nullable();        
            $table->string('notification');            
            $table->dateTime('seen_at')->nullable();
            $table->timestamps();

            $table->foreign('to_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
