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
        Schema::create('admin_actions', function (Blueprint $table) {
            $table->id(); // action_id (Primary Key)
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade'); // Foreign key to Users table
            $table->enum('action_type', ['approve_job', 'reject_job', 'approve_recruiter', 'ban_user', 'unban_user'])->notNull();
            $table->unsignedBigInteger('target_id');
            $table->timestamp('action_timestamp')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_actions');
    }
};
