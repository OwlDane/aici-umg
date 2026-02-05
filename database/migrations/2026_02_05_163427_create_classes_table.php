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
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('code')->unique(); // e.g., AI-FZ-001
            $table->string('level'); // beginner, elementary, intermediate, advanced
            $table->text('description')->nullable();
            $table->text('curriculum')->nullable(); // JSON array
            $table->text('prerequisites')->nullable(); // JSON array
            $table->integer('min_score')->default(0); // Minimum test score required
            $table->integer('min_age')->nullable();
            $table->integer('max_age')->nullable();
            $table->integer('duration_hours')->nullable();
            $table->integer('total_sessions')->nullable();
            $table->decimal('price', 12, 2)->default(0);
            $table->integer('capacity')->default(20);
            $table->integer('enrolled_count')->default(0);
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('program_id');
            $table->index('level');
            $table->index('is_active');
            $table->index('is_featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
