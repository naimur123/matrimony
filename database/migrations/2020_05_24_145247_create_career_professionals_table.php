<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCareerProfessionalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('career_professionals', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('name');

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
        Schema::dropIfExists('career_professionals');
    }
}
