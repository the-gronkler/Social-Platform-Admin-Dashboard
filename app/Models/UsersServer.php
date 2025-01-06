<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UsersServer extends Pivot
{
//    use HasFactory;
    protected $table = 'users_server';


    protected $fillable = [
        'users_id',
        'server_id',
        'is_admin',
        'created_at',
    ];

    public $timestamps = false;

    protected static function booted()
    {
        // if the user being deleted is the last admin,
        // the earliest joined user will be made an admin
        static::deleting(function (UsersServer $usersServer) {
            $server = Server::find($usersServer->server_id);
            if (!$server || $server->users()->isEmpty()) {
                return;
            }

            $serverHas1Admin = $server->users()
                    ->wherePivot('is_admin', true)
                    ->count() == 1;

            if ($usersServer->is_admin && $serverHas1Admin) {
                $earliestJoinedUser = $server->users()->orderBy('users_server.created_at')->first();

                \DB::transaction(function () use ($server, $earliestJoinedUser) {
                    $server->users()
                        ->updateExistingPivot($earliestJoinedUser->id, ['is_admin' => true]);
                });
            }
        });

        // if the server has no users, the first user to join will be an admin
        static::creating(function (UsersServer $usersServer) {
            $server = Server::find($usersServer->server_id);
            if (!$server)
                return;

            if ($server->users()->count() == 0)
                $usersServer->is_admin = true;
        });

        // if the update is removing the last admin's priveleges the earliest joined user will be made an admin
        static::updated(function (UsersServer $usersServer) {
            $server = Server::find($usersServer->server_id);
            if (!$server)
                return;

            // Check if there are no admins on the server
            if ( $server->users()->wherePivot('is_admin', true)->count() > 0)
                return;

            $earliestJoinedUser = $server->users()->orderBy('users_server.created_at')->first();

            \DB::transaction(function () use ($server, $earliestJoinedUser) {
                $server->users()->updateExistingPivot($earliestJoinedUser->id, ['is_admin' => true]);
            });
        });
    }
}
