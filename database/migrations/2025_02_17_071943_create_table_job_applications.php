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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidate_id')->constrained('candidate_profiles')->onDelete('cascade');
            $table->foreignId('job_id')->constrained('job_posts')->onDelete('cascade');
            $table->enum('application_status', ['applied', 'reviewed', 'interview', 'rejected', 'hired'])->default('applied');
            $table->timestamp('applied_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
