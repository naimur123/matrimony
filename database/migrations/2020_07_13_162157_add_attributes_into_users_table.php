<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAttributesIntoUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {            
            $table->bigInteger('division_id')->nullable()->after('user_present_address');
            $table->bigInteger('district_id')->nullable()->after('division_id');
            $table->bigInteger('upozila_id')->nullable()->after('district_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {            
            // $table->dropColumn('division_id');
            // $table->dropColumn('district_id');
            // $table->dropColumn('upozila_id');
        });
    }
}
