<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('title');            
            $table->string('image_path')->nullable();
            $table->text('image_64')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('news');
    }
}
