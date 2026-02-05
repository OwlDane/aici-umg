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
        Schema::create('test_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('placement_test_id')->constrained()->cascadeOnDelete();
            $table->string('status')->default('pending'); // pending, in_progress, completed, expired
            
            // Pre-assessment data
            $table->string('full_name');
            $table->string('email');
            $table->integer('age')->nullable();
            $table->string('education_level')->nullable();
            $table->string('current_grade')->nullable();
            $table->text('experience')->nullable(); // JSON: {ai: false, robotics: true, programming: false}
            $table->text('interests')->nullable(); // JSON array
            
            // Test execution
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->integer('time_spent_seconds')->default(0);
            
            // Scoring
            $table->integer('total_questions')->default(0);
            $table->integer('answered_questions')->default(0);
            $table->integer('correct_answers')->default(0);
            $table->decimal('score', 5, 2)->default(0); // 0-100
            $table->string('level_result')->nullable(); // beginner, elementary, intermediate, advanced
            
            $table->timestamps();
            $table->softDeletes();

            $table->index('user_id');
            $table->index('placement_test_id');
            $table->index('status');
            $table->index('completed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_attempts');
    }
};
