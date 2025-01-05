<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Server;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Website-wide admins can modify data for any server,
 * and server admins can modify data only for their own servers.
 */
class ServerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Server $server): bool
    {
        return $this->isAdminOrServerAdmin($user, $server);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Server $server): bool
    {
        return $this->isAdminOrServerAdmin($user, $server);
    }

    /**
     * Return true if the user is a website-wide admin or a server admin.
     */
    private function isAdminOrServerAdmin(User $user, Server $server): bool
    {
        return $user->role === 'admin' || $server->users()
                ->wherePivot('is_admin', true)
                ->where('user_id', $user->id)->exists();
    }
}
