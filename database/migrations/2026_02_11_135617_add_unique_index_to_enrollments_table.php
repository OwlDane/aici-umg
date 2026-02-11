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
        Schema::table('enrollments', function (Blueprint $table) {
            // Note: This prevents a user from having multiple enrollments for the same class.
            // If the application requires re-enrollment after cancellation, 
            // the cancelled enrollment must be soft-deleted or the index must be more complex.
            $table->unique(['user_id', 'class_id'], 'user_class_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->dropUnique('user_class_unique');
        });
    }
};
