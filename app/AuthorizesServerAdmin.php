<?php

namespace App;

use App\Models\Server;
use App\Models\User;

trait AuthorizesServerAdmin
{
    /**
     * Return true if the user is a website-wide admin or a server admin.
     */
    protected function isAdminOrServerAdmin(?User $user, Server $server): bool
    {
        return $user != null && ($user->role === 'admin' || $server->users()
                    ->wherePivot('is_admin', true)
                    ->where('user_id', $user->id)->exists());
    }
}
