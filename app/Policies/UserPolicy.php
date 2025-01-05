<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return true; // Any logged in user can view the list
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, User $targetUser): bool
    {
        return $user != null
            && ($user->id === $targetUser->id || $user->role === 'admin'); // Only admins can view other users
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(?User $user): bool
    {
        return $user != null && $user->role === 'admin'; // Only admins can create users
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(?User $user, User $targetUser): bool
    {
        // Only admins can update other users, but users can update themselves
        return $user != null && ($user->id === $targetUser->id || $user->role === 'admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?User $user, User $targetUser): bool
    {
        return $user != null && $user->role === 'admin'; // Only admins can delete users
    }
}
