<?php

namespace App\Policies;

use App\AuthorizesServerAdmin;
use App\Models\User;
use App\Models\Server;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Website-wide admins can modify data for any server,
 * and server admins can modify data only for their own servers.
 * Anyone can view servers, but only logged in users can create.
 */
class ServerPolicy
{
    use HandlesAuthorization, AuthorizesServerAdmin;

    /**
     * Determine whether the user can update the model.
     */
    public function update(?User $user, Server $server): bool
    {
        return $this->isAdminOrServerAdmin($user, $server);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?User $user, Server $server): bool
    {
        return $this->isAdminOrServerAdmin($user, $server);
    }

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
    public function view(?User $user, Server $server): bool
    {
        return true; // Any user can view server details
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(?User $user): bool
    {
        return $user != null; // Any logged in user can create a server
    }
}
