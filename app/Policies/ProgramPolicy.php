<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Program;
use App\Models\User;
use Illuminate\Auth\Access\Response;

/**
 * Program Policy
 * 
 * Access Control:
 * - Admin: Full access (view, create, update, delete, restore, force delete)
 * - Public User: No access to admin panel
 * 
 * Security Notes:
 * - Only admin role can manage programs
 * - All operations logged via Auditable trait
 * - Soft deletes enabled for data recovery
 */
class ProgramPolicy
{
    /**
     * Determine whether the user can view any models.
     * 
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        // Only admin can view programs list in admin panel
        return $user->role === UserRole::ADMIN;
    }

    /**
     * Determine whether the user can view the model.
     * 
     * @param User $user
     * @param Program $program
     * @return bool
     */
    public function view(User $user, Program $program): bool
    {
        // Only admin can view program details in admin panel
        return $user->role === UserRole::ADMIN;
    }

    /**
     * Determine whether the user can create models.
     * 
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        // Only admin can create programs
        return $user->role === UserRole::ADMIN;
    }

    /**
     * Determine whether the user can update the model.
     * 
     * @param User $user
     * @param Program $program
     * @return bool
     */
    public function update(User $user, Program $program): bool
    {
        // Only admin can update programs
        return $user->role === UserRole::ADMIN;
    }

    /**
     * Determine whether the user can delete the model.
     * 
     * @param User $user
     * @param Program $program
     * @return bool
     */
    public function delete(User $user, Program $program): bool
    {
        // Only admin can soft delete programs
        return $user->role === UserRole::ADMIN;
    }

    /**
     * Determine whether the user can restore the model.
     * 
     * @param User $user
     * @param Program $program
     * @return bool
     */
    public function restore(User $user, Program $program): bool
    {
        // Only admin can restore soft deleted programs
        return $user->role === UserRole::ADMIN;
    }

    /**
     * Determine whether the user can permanently delete the model.
     * 
     * @param User $user
     * @param Program $program
     * @return bool
     */
    public function forceDelete(User $user, Program $program): bool
    {
        // Only admin can permanently delete programs
        // This is a destructive operation and should be used carefully
        return $user->role === UserRole::ADMIN;
    }
}
