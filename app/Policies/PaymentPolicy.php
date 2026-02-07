<?php

namespace App\Policies;

use App\Enums\PaymentStatus;
use App\Enums\UserRole;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

/**
 * Payment Policy
 * 
 * Access Control:
 * - Admin: Can view all payments, check status, process refunds
 * - Public User: Can only view their own payments
 * 
 * Security Rules:
 * - Payments are read-only (created via enrollment flow)
 * - No one can manually create/edit payments
 * - Only admin can process refunds
 * - Users can only view their own payment history
 * - No one can delete payment records (audit trail)
 */
class PaymentPolicy
{
    /**
     * Determine whether the user can view any models.
     * 
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        // Admin can view all payments
        // Public users will see filtered list (their own) via query scope
        return $user->role === UserRole::ADMIN || $user->role === UserRole::PUBLIC;
    }

    /**
     * Determine whether the user can view the model.
     * 
     * @param User $user
     * @param Payment $payment
     * @return bool
     */
    public function view(User $user, Payment $payment): bool
    {
        // Admin can view any payment
        if ($user->role === UserRole::ADMIN) {
            return true;
        }
        
        // Public user can only view their own payments
        return $user->id === $payment->user_id;
    }

    /**
     * Determine whether the user can create models.
     * 
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        // No one can manually create payments
        // Payments are created automatically via enrollment flow
        return false;
    }

    /**
     * Determine whether the user can update the model.
     * 
     * @param User $user
     * @param Payment $payment
     * @return bool
     */
    public function update(User $user, Payment $payment): bool
    {
        // No one can manually update payments
        // Payment status updated via Xendit webhook
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     * 
     * @param User $user
     * @param Payment $payment
     * @return bool
     */
    public function delete(User $user, Payment $payment): bool
    {
        // No one can delete payment records
        // Required for audit trail and financial records
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     * 
     * @param User $user
     * @param Payment $payment
     * @return bool
     */
    public function restore(User $user, Payment $payment): bool
    {
        // Only admin can restore soft deleted payments
        return $user->role === UserRole::ADMIN;
    }

    /**
     * Determine whether the user can permanently delete the model.
     * 
     * @param User $user
     * @param Payment $payment
     * @return bool
     */
    public function forceDelete(User $user, Payment $payment): bool
    {
        // No one can permanently delete payment records
        // Critical for financial audit and compliance
        return false;
    }

    /**
     * Determine whether the user can check payment status.
     * 
     * Custom policy method for manual status check
     * 
     * @param User $user
     * @param Payment $payment
     * @return bool
     */
    public function checkStatus(User $user, Payment $payment): bool
    {
        // Admin can check any payment status
        if ($user->role === UserRole::ADMIN) {
            return true;
        }
        
        // Public user can check their own pending payments
        return $user->id === $payment->user_id 
            && $payment->status === PaymentStatus::PENDING;
    }

    /**
     * Determine whether the user can process refund.
     * 
     * Custom policy method for refund processing
     * 
     * @param User $user
     * @param Payment $payment
     * @return bool
     */
    public function refund(User $user, Payment $payment): bool
    {
        // Only admin can process refunds
        // Payment must be paid and not already refunded
        return $user->role === UserRole::ADMIN 
            && $payment->status === PaymentStatus::PAID
            && $payment->refunded_at === null;
    }

    /**
     * Determine whether the user can view invoice.
     * 
     * Custom policy method for viewing Xendit invoice
     * 
     * @param User $user
     * @param Payment $payment
     * @return bool
     */
    public function viewInvoice(User $user, Payment $payment): bool
    {
        // Admin can view any invoice
        if ($user->role === UserRole::ADMIN) {
            return true;
        }
        
        // Public user can view their own invoice
        return $user->id === $payment->user_id;
    }
}
