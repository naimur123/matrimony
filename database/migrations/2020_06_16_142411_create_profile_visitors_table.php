<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileVisitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_visitors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('visit_profile_id');
            $table->unsignedBigInteger('visitor_profile_id');
            $table->timestamps();
            $table->foreign('visit_profile_id')->references('id')->on('users');
            $table->foreign('visitor_profile_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profile_visitors');
    }
}
