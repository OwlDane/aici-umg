<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Payment API Resource
 * 
 * Transform Payment model untuk API response
 * SECURITY: Mask sensitive payment data
 */
class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $isOwner = $request->user()?->id === $this->user_id;
        $isAdmin = $request->user()?->isAdmin() ?? false;
        $canViewFull = $isOwner || $isAdmin;

        return [
            'id' => $this->id,
            'invoice_number' => $this->invoice_number,
            'enrollment_id' => $this->enrollment_id,
            'user_id' => $this->user_id,
            
            // Amounts
            'amount' => $this->amount,
            'admin_fee' => $this->admin_fee,
            'total_amount' => $this->total_amount,
            'currency' => $this->currency,
            
            // Formatted amounts
            'amount_formatted' => formatCurrency($this->amount),
            'admin_fee_formatted' => formatCurrency($this->admin_fee),
            'total_amount_formatted' => formatCurrency($this->total_amount),
            
            // Payment info
            'payment_method' => $this->payment_method,
            'payment_channel' => $this->payment_channel,
            'status' => $this->status->value,
            'status_label' => $this->status->label(),
            
            // Xendit data (masked untuk non-owner/non-admin)
            'xendit_invoice_url' => $this->when($canViewFull, $this->xendit_invoice_url),
            'xendit_invoice_id' => $this->when($isAdmin, $this->masked_xendit_invoice_id),
            'account_number' => $this->when($isAdmin, $this->masked_account_number),
            
            // Timestamps
            'paid_at' => $this->paid_at?->toISOString(),
            'expired_at' => $this->expired_at?->toISOString(),
            'refunded_at' => $this->refunded_at?->toISOString(),
            
            // Refund info (only for owner/admin)
            'refund_amount' => $this->when($canViewFull && $this->refund_amount, $this->refund_amount),
            'refund_reason' => $this->when($canViewFull, $this->refund_reason),
            
            // Relationships
            'enrollment' => new EnrollmentResource($this->whenLoaded('enrollment')),
            
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
