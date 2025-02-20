<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyRecruiterIdOnJobPostsTable extends Migration
{
    public function up()
    {
        Schema::table('job_posts', function (Blueprint $table) {

            $table->unsignedBigInteger('recruiter_id')->default(0)->change();
        });
    }

    public function down()
    {
        Schema::table('job_posts', function (Blueprint $table) {
            $table->unsignedBigInteger('recruiter_id')->default(null)->change();
        });
    }
}
