<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnIntoSubscribePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscribe_packages', function (Blueprint $table) {
            $table->enum('payment_type',['online','offline'])->default('online')->after('payment_status');
            $table->string('payment_method')->default('sslcommerz')->after('payment_type');
            $table->string('comments')->nullable()->after('payment_method');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscribe_packages', function (Blueprint $table) {
            $table->dropColumn('payment_type');
            $table->dropColumn('payment_method');
            $table->dropColumn('comments');
        });
    }
}
