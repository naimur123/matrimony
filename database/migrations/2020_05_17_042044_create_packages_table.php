<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image_path')->nullable();
            $table->text('image_64')->nullable();

            // Package details
            $table->double('duration');
            $table->enum('duration_type',['day', 'month', 'year']);
            $table->string('profile_view');
            $table->enum('contact_details',['yes','no']);
            $table->integer('total_proposal')->default(30000);
            $table->integer('daily_proposal')->default(1000);
            // $table->integer('total_send_message');
            // $table->integer('daily_send_message');
            $table->enum('block_profile',['yes','no']);
            $table->integer('accept_proposal');
            // $table->integer('decline_proposal');
            $table->integer('post_photo');
            $table->double('regular_fee');
            $table->double('discount_percentage');
            $table->double('current_fee');

            $table->enum('status',['published','unpublished']);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
            
            $table->foreign('created_by')->references('id')->on('admins');
            $table->foreign('modified_by')->references('id')->on('admins');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packages');
    }
}
