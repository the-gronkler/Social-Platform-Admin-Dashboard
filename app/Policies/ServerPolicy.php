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

    public function update(?User $user, Server $server): bool
    {
        return $this->isAdminOrServerAdmin($user, $server);
    }

    public function delete(?User $user, Server $server): bool
    {
        return $this->isAdminOrServerAdmin($user, $server);
    }

    public function viewAny(?User $user): bool
    {
        return true; // Any logged in user can view the list
    }

    public function view(?User $user, Server $server): bool
    {
        return true; // Any user can view server details
    }

    public function create(?User $user): bool
    {
        return $user != null; // Any logged in user can create a server
    }
}
