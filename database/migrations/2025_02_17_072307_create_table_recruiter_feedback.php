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
        Schema::create('recruiter_feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('job_applications')->onDelete('cascade');
            $table->foreignId('recruiter_id')->constrained('recruiters')->onDelete('cascade');
            $table->text('feedback_text');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruiter_feedback');
    }
};
