<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('job_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recruiter_id')->constrained('recruiters')->onDelete('cascade');
            $table->string('job_title', 255);
            $table->text('job_description');
            $table->text('job_requirements');
            $table->string('job_location', 255);
            $table->enum('job_type', ['full-time', 'part-time', 'contract', 'internship']);
            $table->string('salary_range', 100)->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_posts');
    }
};
