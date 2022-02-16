<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAttributeIntoServicesNewsBlogTestimonialSuccessStoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->string('meta_tag')->nullable()->after('title');
            $table->string('meta_description')->nullable()->after('meta_tag');
        });

        Schema::table('news', function (Blueprint $table) {
            $table->string('meta_tag')->nullable()->after('title');
            $table->string('meta_description')->nullable()->after('meta_tag');
        });

        Schema::table('success_stories', function (Blueprint $table) {
            $table->string('meta_tag')->nullable()->after('title');
            $table->string('meta_description')->nullable()->after('meta_tag');
        });

        Schema::table('our_services', function (Blueprint $table) {
            $table->string('meta_tag')->nullable()->after('title');
            $table->string('meta_description')->nullable()->after('meta_tag');
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->string('meta_tag')->nullable()->after('title');
            $table->string('meta_description')->nullable()->after('meta_tag');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn('meta_tag');
            $table->dropColumn('meta_description');
        });

        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('meta_tag');
            $table->dropColumn('meta_description');
        });

        Schema::table('our_services', function (Blueprint $table) {
            $table->dropColumn('meta_tag');
            $table->dropColumn('meta_description');
        });

        Schema::table('success_stories', function (Blueprint $table) {
            $table->dropColumn('meta_tag');
            $table->dropColumn('meta_description');
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropColumn('meta_tag');
            $table->dropColumn('meta_description');
        });
    }
}
