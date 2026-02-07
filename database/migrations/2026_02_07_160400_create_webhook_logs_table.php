<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Webhook Logs Table
     * Store all incoming webhook requests for audit trail and debugging
     * 
     * Security Benefits:
     * - Track all webhook attempts (successful and failed)
     * - Detect replay attacks
     * - Identify suspicious patterns
     * - Audit trail for compliance
     */
    public function up(): void
    {
        Schema::create('webhook_logs', function (Blueprint $table) {
            $table->id();
            $table->string('source')->index(); // xendit, etc.
            $table->string('event_type')->nullable(); // invoice.paid, invoice.expired, etc.
            $table->string('external_id')->nullable()->index(); // Reference ID from webhook
            $table->text('payload'); // Full webhook payload (JSON)
            $table->text('headers')->nullable(); // Request headers (JSON)
            $table->string('ip_address', 45)->index(); // IPv4 or IPv6
            $table->string('user_agent')->nullable();
            $table->enum('status', ['success', 'failed', 'invalid'])->index();
            $table->text('error_message')->nullable(); // Error details if failed
            $table->timestamp('processed_at')->nullable(); // When webhook was processed
            $table->timestamps();

            // Indexes for performance
            $table->index('created_at');
            $table->index(['source', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('webhook_logs');
    }
};
