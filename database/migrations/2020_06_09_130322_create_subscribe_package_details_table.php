<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscribePackageDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscribe_package_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subscribe_package_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image_path')->nullable();
            $table->text('image_64')->nullable();

            // Package details
            $table->string('profile_view');
            $table->enum('contact_details',['yes','no']);
            $table->integer('total_proposal')->default(0);
            $table->integer('daily_proposal')->default(0);
            // $table->integer('total_send_message');
            // $table->integer('daily_send_message');
            $table->enum('block_profile',['yes','no']);
            $table->integer('accept_proposal');
            // $table->integer('decline_proposal');
            $table->integer('post_photo');
            $table->timestamps();

            $table->foreign('subscribe_package_id')->references('id')->on('subscribe_packages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscribe_package_details');
    }
}
