<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateDivisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('divisions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('bn_name');
            $table->string('url')->nullable();
            $table->timestamps();
        });

        $this->insert();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('divisions');
    }

    protected function insert(){
        DB::statement("
            INSERT INTO `divisions` (`id`, `name`, `bn_name`, `url`) VALUES
            (1, 'Chattagram', 'চট্টগ্রাম', 'www.chittagongdiv.gov.bd'),
            (2, 'Rajshahi', 'রাজশাহী', 'www.rajshahidiv.gov.bd'),
            (3, 'Khulna', 'খুলনা', 'www.khulnadiv.gov.bd'),
            (4, 'Barisal', 'বরিশাল', 'www.barisaldiv.gov.bd'),
            (5, 'Sylhet', 'সিলেট', 'www.sylhetdiv.gov.bd'),
            (6, 'Dhaka', 'ঢাকা', 'www.dhakadiv.gov.bd'),
            (7, 'Rangpur', 'রংপুর', 'www.rangpurdiv.gov.bd'),
            (8, 'Mymensingh', 'ময়মনসিংহ', 'www.mymensinghdiv.gov.bd');"
        );
    }
}
