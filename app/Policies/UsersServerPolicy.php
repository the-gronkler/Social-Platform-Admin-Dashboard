<?php

namespace App\Policies;

use App\AuthorizesServerAdmin;
use App\Models\Server;
use App\Models\User;
use App\Models\UsersServer;
use Illuminate\Auth\Access\HandlesAuthorization;

class UsersServerPolicy
{
    use HandlesAuthorization, AuthorizesServerAdmin;

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, UsersServer $usersServer): bool
    {
        // anyone can view the association
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(?User $user): bool
    {
        return $user != null; // Any logged in user can create the association
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(?User $user, UsersServer $usersServer): bool
    {
        $server = Server::find($usersServer->server_id);
        if ($server == null) {
            return false;
        }
        return $this->isAdminOrServerAdmin($user, $server);
    }


    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?User $user, UsersServer $usersServer): bool
    {
        $server = Server::find($usersServer->server_id);
        if ($server == null) {
            return false;
        }
        return $this->isAdminOrServerAdmin($user, $server);
    }
}
