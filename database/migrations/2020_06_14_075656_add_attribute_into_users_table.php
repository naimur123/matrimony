<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAttributeIntoUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('eye_color')->nullable()->after('mother_tongue');
            $table->string('hair_color')->nullable()->after('eye_color');
            $table->string('complexion')->nullable()->after('hair_color');
            $table->string('drink')->nullable()->after('complexion');
            $table->string('diet')->nullable()->after('drink');
            $table->string('no_children')->nullable()->after('diet');
            $table->text('family_details')->nullable()->after('no_children');
            $table->string('family_values')->nullable()->after('family_details');
            $table->string('major_subject')->nullable()->after('family_values');
            
            
            $table->string('partner_min_height')->nullable()->after('major_subject');
            $table->string('partner_max_height')->nullable()->after('partner_min_height');
            $table->string('partner_min_age')->nullable()->after('partner_max_height');
            $table->string('partner_max_age')->nullable()->after('partner_min_age');  
            $table->string('partner_body_color')->nullable()->after('partner_max_age');
            $table->text('partner_blood_group')->nullable()->after('partner_body_color');
            $table->string('partner_eye_color')->nullable()->after('partner_blood_group');
            $table->string('partner_complexion')->nullable()->after('partner_eye_color');
            $table->string('partner_dite')->nullable()->after('partner_complexion');
            $table->string('partner_father_occupation')->nullable()->after('partner_dite');
            $table->string('partner_mother_occupation')->nullable()->after('partner_father_occupation');

            $table->text('partner_marital_status')->nullable()->after('partner_mother_occupation');
            $table->text('partner_religion')->nullable()->after('partner_marital_status');
            $table->text('partner_religion_cast')->nullable()->after('partner_religion');
            $table->text('partner_mother_tongue')->nullable()->after('partner_religion_cast');
            $table->text('partner_city')->nullable()->after('partner_mother_tongue');            
            $table->text('partner_country')->nullable()->after('partner_city');
            $table->text('partner_education')->nullable()->after('partner_country');
            $table->text('partner_profession')->nullable()->after('partner_education'); 
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
            $table->dropColumn('eye_color');
            $table->dropColumn('hair_color');
            $table->dropColumn('complexion');
            $table->dropColumn('drink');
            $table->dropColumn('diet');
            $table->dropColumn('no_children');
            $table->dropColumn('family_details ');
            $table->dropColumn('family_values');
            $table->dropColumn('major_subject');
            
            $table->dropColumn('partner_min_height');
            $table->dropColumn('partner_max_height');
            $table->dropColumn('partner_min_age');
            $table->dropColumn('partner_max_age');
            $table->dropColumn('partner_body_color');
            $table->dropColumn('partner_blood_group');
            $table->dropColumn('partner_eye_color');
            $table->dropColumn('partner_complexion');
            $table->dropColumn('partner_dite');
            $table->dropColumn('partner_father_occupation');
            $table->dropColumn('partner_mother_occupation');
            $table->dropColumn('marital_status');
            $table->dropColumn('partner_religion');
            $table->dropColumn('partner_religion_cast');
            $table->dropColumn('partner_mother_tongue');
            $table->dropColumn('partner_city');
            $table->dropColumn('partner_country');
            $table->dropColumn('partner_education');
            $table->dropColumn('partner_profession');
        });
    }
}
