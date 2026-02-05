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
        Schema::create('test_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_attempt_id')->unique()->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            // Overall results
            $table->decimal('overall_score', 5, 2);
            $table->string('level_achieved'); // beginner, elementary, intermediate, advanced
            
            // Category breakdown (JSON)
            $table->text('category_scores')->nullable(); // {logical_thinking: 80, programming: 60, ...}
            $table->text('strengths')->nullable(); // JSON array
            $table->text('weaknesses')->nullable(); // JSON array
            
            // Recommendations (JSON array of class IDs with match percentage)
            $table->text('recommended_classes')->nullable();
            $table->text('recommendation_reasons')->nullable();
            
            // Analysis
            $table->text('performance_summary')->nullable();
            $table->text('next_steps')->nullable();
            
            $table->timestamps();

            $table->index('user_id');
            $table->index('level_achieved');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_results');
    }
};
