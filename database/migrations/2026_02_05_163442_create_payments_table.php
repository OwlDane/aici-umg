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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('enrollment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            // Payment details
            $table->decimal('amount', 12, 2);
            $table->decimal('admin_fee', 12, 2)->default(0);
            $table->decimal('total_amount', 12, 2);
            $table->string('currency')->default('IDR');
            
            // Payment method & gateway
            $table->string('payment_method'); // bank_transfer, virtual_account, ewallet, qris
            $table->string('payment_channel')->nullable(); // BCA, OVO, etc.
            $table->string('status')->default('pending'); // pending, paid, failed, expired, refunded
            
            // Xendit integration
            $table->string('xendit_invoice_id')->nullable()->unique();
            $table->string('xendit_invoice_url')->nullable();
            $table->string('xendit_external_id')->nullable();
            $table->text('xendit_response')->nullable(); // JSON
            
            // Payment info
            $table->string('account_number')->nullable(); // VA number or account
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->text('payment_proof')->nullable(); // For manual verification
            
            // Refund info
            $table->timestamp('refunded_at')->nullable();
            $table->decimal('refund_amount', 12, 2)->nullable();
            $table->text('refund_reason')->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->index('enrollment_id');
            $table->index('user_id');
            $table->index('status');
            $table->index('xendit_invoice_id');
            $table->index('paid_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
