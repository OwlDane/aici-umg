<?php

namespace App\Policies;

use App\Enums\EnrollmentStatus;
use App\Enums\UserRole;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

/**
 * Enrollment Policy
 * 
 * Access Control:
 * - Admin: Full access to all enrollments
 * - Public User: Can only view/manage their own enrollments
 * 
 * Security Rules:
 * - Users can only see their own enrollment data
 * - Only admin can confirm/cancel enrollments
 * - Users can cancel their own pending enrollments
 * - No one can force delete (data retention)
 */
class EnrollmentPolicy
{
    /**
     * Determine whether the user can view any models.
     * 
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        // Admin can view all enrollments
        // Public users will see filtered list (their own) via query scope
        return $user->role === UserRole::ADMIN || $user->role === UserRole::PUBLIC;
    }

    /**
     * Determine whether the user can view the model.
     * 
     * @param User $user
     * @param Enrollment $enrollment
     * @return bool
     */
    public function view(User $user, Enrollment $enrollment): bool
    {
        // Admin can view any enrollment
        if ($user->role === UserRole::ADMIN) {
            return true;
        }
        
        // Public user can only view their own enrollment
        return $user->id === $enrollment->user_id;
    }

    /**
     * Determine whether the user can create models.
     * 
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        // Only admin can create enrollments via admin panel
        // Public users create via frontend enrollment form
        return $user->role === UserRole::ADMIN;
    }

    /**
     * Determine whether the user can update the model.
     * 
     * @param User $user
     * @param Enrollment $enrollment
     * @return bool
     */
    public function update(User $user, Enrollment $enrollment): bool
    {
        // Only admin can update enrollments
        // This includes status changes, student info updates, etc.
        return $user->role === UserRole::ADMIN;
    }

    /**
     * Determine whether the user can delete the model.
     * 
     * @param User $user
     * @param Enrollment $enrollment
     * @return bool
     */
    public function delete(User $user, Enrollment $enrollment): bool
    {
        // Admin can soft delete any enrollment
        if ($user->role === UserRole::ADMIN) {
            return true;
        }
        
        // Public user can cancel (soft delete) their own pending enrollment
        return $user->id === $enrollment->user_id 
            && $enrollment->status === EnrollmentStatus::PENDING;
    }

    /**
     * Determine whether the user can restore the model.
     * 
     * @param User $user
     * @param Enrollment $enrollment
     * @return bool
     */
    public function restore(User $user, Enrollment $enrollment): bool
    {
        // Only admin can restore soft deleted enrollments
        return $user->role === UserRole::ADMIN;
    }

    /**
     * Determine whether the user can permanently delete the model.
     * 
     * @param User $user
     * @param Enrollment $enrollment
     * @return bool
     */
    public function forceDelete(User $user, Enrollment $enrollment): bool
    {
        // No one can force delete enrollments
        // Data retention policy: keep all enrollment records
        return false;
    }

    /**
     * Determine whether the user can confirm the enrollment.
     * 
     * Custom policy method for enrollment confirmation
     * 
     * @param User $user
     * @param Enrollment $enrollment
     * @return bool
     */
    public function confirm(User $user, Enrollment $enrollment): bool
    {
        // Only admin can confirm enrollments
        return $user->role === UserRole::ADMIN 
            && $enrollment->status === EnrollmentStatus::PENDING;
    }

    /**
     * Determine whether the user can cancel the enrollment.
     * 
     * Custom policy method for enrollment cancellation
     * 
     * @param User $user
     * @param Enrollment $enrollment
     * @return bool
     */
    public function cancel(User $user, Enrollment $enrollment): bool
    {
        // Admin can cancel any enrollment
        if ($user->role === UserRole::ADMIN) {
            return true;
        }
        
        // Public user can cancel their own pending enrollment
        return $user->id === $enrollment->user_id 
            && $enrollment->status === EnrollmentStatus::PENDING;
    }
}
