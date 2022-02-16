<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email', 100)->unique();
            $table->string('password');
            $table->rememberToken();
            $table->enum('user_type', ['super_admin','admin'])->default('admin');
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('image')->nullable();
            
            $table->string('created_by')->default('system');
            $table->string('modified_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
