<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIntoUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->enum('creating_account',['self','brother','sister','friend','relatives','father','mother'])->nullable()->after('phone');
            $table->enum('looking_for',['bride','groom'])->nullable()->after('creating_account');
            $table->enum('gender',['M','F'])->nullable()->after('looking_for');
            $table->string('first_name')->nullable()->after('gender');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('location_country')->nullable()->after('last_name');
            $table->date('date_of_birth')->nullable()->after('location_country');            
            $table->string('nid')->nullable()->after('date_of_birth');           
            $table->string('passport')->nullable()->after('nid');
            $table->string('nid_image')->nullable()->after('passport');
            $table->string('passport_image')->nullable()->after('nid_image');
            
            $table->unsignedBigInteger('education_level_id')->nullable()->after('passport_image');
            $table->string('edu_institute_name')->nullable()->after('education_level_id');
            $table->string('career_working_name')->nullable()->after('edu_institute_name');
            $table->string('organisation')->nullable()->after('career_working_name');
            $table->unsignedBigInteger('career_working_profession_id')->nullable()->after('career_working_name');
            $table->unsignedBigInteger('career_monthly_income_id')->nullable()->after('career_working_profession_id');
            
            $table->unsignedBigInteger('lifestyle_id')->nullable()->after('career_monthly_income_id');
            $table->string('marital_status')->nullable()->after('lifestyle_id');
            $table->string('user_height')->nullable()->after('marital_status');
            $table->string('user_body_weight')->nullable()->after('user_height');
            $table->string('user_blood_group')->nullable()->after('user_body_weight');
            $table->string('user_body_color')->nullable()->after('user_blood_group');
            $table->enum('user_fitness_disabilities',['Y','N'])->nullable()->after('user_body_color');
            $table->enum('smoke',['Yes','No'])->nullable()->after('user_fitness_disabilities');
            $table->string('mother_tongue')->nullable()->after('smoke');
            
            $table->string('no_of_brother')->nullable()->after('mother_tongue');
            $table->string('no_of_sister')->nullable()->after('no_of_brother');
            $table->string('father_name')->nullable()->after('no_of_sister');
            $table->string('father_occupation')->nullable()->after('father_name');
            $table->string('mother_name')->nullable()->after('father_occupation');
            $table->string('mother_occupation')->nullable()->after('mother_name');
            $table->string('gardian_contact_no')->nullable()->after('mother_occupation');           
            $table->unsignedBigInteger('religious_id')->nullable()->after('gardian_contact_no');            
            $table->unsignedBigInteger('religious_cast_id')->nullable()->after('religious_id');

            $table->text('user_present_address')->nullable()->after('religious_cast_id');
            $table->string('user_present_city')->nullable()->after('user_present_address');
            $table->string('user_present_country')->nullable()->after('user_present_city');
            $table->text('user_permanent_address')->nullable()->after('user_present_country');
            $table->string('user_permanent_city')->nullable()->after('user_permanent_address');
            $table->string('user_permanent_country')->nullable()->after('user_permanent_city');            

            $table->text('user_bio_myself')->nullable()->after('user_permanent_country');
            $table->string('user_bio_data_path')->nullable()->after('user_bio_myself');
            $table->boolean('user_status')->nullable()->after('user_bio_data_path');
            $table->boolean('is_online')->default(false)->after('user_status');
            $table->dateTime('login_at')->nullable()->after('is_online');
            $table->string('signup_ip')->nullable()->after('login_at');           
            $table->unsignedBigInteger('subscribe_package_id')->nullable()->after('signup_ip');
            $table->unsignedBigInteger('created_by')->nullable()->after('subscribe_package_id');
            $table->unsignedBigInteger('modified_by')->nullable()->after('created_by');
            $table->softDeletes()->after('remember_token');            
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
            $table->dropColumn('phone');
            $table->dropColumn('creating_account');
            $table->dropColumn('looking_for');
            $table->dropColumn('gender');
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('location_country');
            $table->dropColumn('date_of_birth');
            $table->dropColumn('nid');
            $table->dropColumn('passport');
            $table->dropColumn('nid_image');
            $table->dropColumn('passport_image');

            $table->dropColumn('education_level_id');
            $table->dropColumn('edu_institute_name');
            $table->dropColumn('career_working_name');
            $table->dropColumn('organisation');
            $table->dropColumn('career_working_profession_id');
            $table->dropColumn('career_monthly_income_id');

            $table->dropColumn('lifestyle_id');
            $table->dropColumn('marital_status');
            $table->dropColumn('user_height');
            $table->dropColumn('user_body_weight');
            $table->dropColumn('user_blood_group');
            $table->dropColumn('user_body_color');
            $table->dropColumn('user_fitness_disabilities');
            $table->dropColumn('smoke');
            $table->dropColumn('mother_tongue');

            $table->dropColumn('no_of_brother');
            $table->dropColumn('no_of_sister');
            $table->dropColumn('father_occupation');
            $table->dropColumn('father_name');
            $table->dropColumn('mother_occupation');
            $table->dropColumn('mother_name');
            $table->dropColumn('gardian_contact_no');
            $table->dropColumn('religious_id');
            $table->dropColumn('religious_cast_id');

            $table->dropColumn('user_present_address');
            $table->dropColumn('user_present_city');
            $table->dropColumn('user_present_country');
            $table->dropColumn('user_permanent_address');
            $table->dropColumn('user_permanent_city');
            $table->dropColumn('user_permanent_country');
            $table->dropColumn('user_bio_myself');
            $table->dropColumn('user_bio_data_path');
            $table->dropColumn('user_status');
            $table->dropColumn('is_online');
            $table->dropColumn('login_at');
            $table->dropColumn('signup_ip');
            $table->dropColumn('subscribe_package_id');
            $table->dropColumn('created_by');
            $table->dropColumn('modified_by');
            $table->dropColumn('deleted_at');
        });
    }
}
