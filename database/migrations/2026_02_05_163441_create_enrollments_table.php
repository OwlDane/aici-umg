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
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->string('enrollment_number')->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('class_id')->constrained()->cascadeOnDelete();
            $table->foreignId('class_schedule_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('test_result_id')->nullable()->constrained('test_results')->nullOnDelete();
            
            $table->string('status')->default('pending'); // pending, confirmed, cancelled, completed, waiting_list
            
            // Student information
            $table->string('student_name');
            $table->string('student_email');
            $table->string('student_phone');
            $table->integer('student_age')->nullable();
            $table->string('student_grade')->nullable();
            
            // Parent/Guardian information (for minors)
            $table->string('parent_name')->nullable();
            $table->string('parent_phone')->nullable();
            $table->string('parent_email')->nullable();
            
            // Additional info
            $table->text('special_requirements')->nullable();
            $table->text('notes')->nullable();
            
            // Timestamps
            $table->timestamp('enrolled_at')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->string('cancellation_reason')->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->index('user_id');
            $table->index('class_id');
            $table->index('status');
            $table->index('enrolled_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
