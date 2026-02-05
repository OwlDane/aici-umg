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
        Schema::create('test_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('placement_test_id')->constrained()->cascadeOnDelete();
            $table->string('category'); // logical_thinking, basic_programming, etc.
            $table->string('type'); // multiple_choice, true_false, scenario
            $table->string('difficulty'); // beginner, elementary, intermediate, advanced
            $table->text('question');
            $table->text('options')->nullable(); // JSON array for choices
            $table->string('correct_answer');
            $table->text('explanation')->nullable();
            $table->string('image')->nullable();
            $table->integer('points')->default(1);
            $table->integer('time_limit_seconds')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('placement_test_id');
            $table->index('category');
            $table->index('difficulty');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_questions');
    }
};
