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
        Schema::create('placement_tests', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('education_level'); // sd_mi, smp_mts, sma_ma_smk, university
            $table->integer('duration_minutes')->default(30);
            $table->integer('total_questions')->default(0);
            $table->integer('passing_score')->default(60);
            $table->text('instructions')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('show_result_immediately')->default(true);
            $table->boolean('allow_retake')->default(false);
            $table->integer('retake_cooldown_days')->default(7);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('education_level');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('placement_tests');
    }
};
