<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterJobRequirementsNullableOnJobPostsTable extends Migration
{
    public function up()
    {
        Schema::table('job_posts', function (Blueprint $table) {
            $table->text('job_requirements')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('job_posts', function (Blueprint $table) {
            $table->text('job_requirements')->nullable(false)->change();
        });
    }
}
