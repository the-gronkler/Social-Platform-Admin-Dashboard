<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Server;
use App\Models\UsersServer;
use App\Http\Requests\StoreUsersServerRequest;
use App\Http\Requests\UpdateUsersServerRequest;

class UsersServerController extends Controller
{
    /**
     * Display the specified user-server association.
     */
    public function show(string $users_server)
    {
        [$userId, $serverId] = explode('-', $users_server);
        $server = Server::findOrFail($serverId);
        $user = $server->users()->wherePivot('user_id', $userId)->firstOrFail();
        return view('users_server.show', compact('server', 'user'));
    }

    /**
     * Show the form for creating a new user-server association for a specific server.
     */
    public function createForServer(Server $server)
    {
        // select users who are not members for the server
        $users = User::whereDoesntHave('servers',
            fn($query) => $query->where('server_id', $server->id))
        ->get();

//        dd($users);

        // if there are no users who are not members for the server, add error message to users_server.create-for-server
        $errors = [];
        if ($users->count() === 0) {
            $errors['no_users'] = 'There are no existing users you can add to this server.';
        }
        // check capacity
        if ($server->users->count() >= $server->capacity) {
            $errors['capacity'] = 'The server is full. Cant add members';
        }

        return view('users_server.create-for-server', compact('server', 'users'))
            ->withErrors($errors);
    }


    /**
     * Show the form for creating a new user-server association for a specific user.
     */
    public function createForUser(User $user)
    {
        // select servers where the user is not a member
        $servers = Server::whereDoesntHave('users',
            fn($query) => $query->where('user_id', $user->id)
        )
        ->where('capacity', '>', $user->servers->count())
        ->get();



        return view('users_server.create-for-user', compact('user', 'servers'));
    }


    /**
     * Store a new user-server association.
     */
    public function store(StoreUsersServerRequest $request)
    {
        // check if an associeatoon with $request->server_id and $request->user_id already exists
        if (UsersServer::where('server_id', $request->server_id)
            ->where('user_id', $request->user_id)
            ->exists()
        ) {
            return redirect()->back()->withErrors([
                'server_id' => 'This user is already a member of this server.',
            ]);
        }

        $server = Server::findOrFail($request->server_id);
        $server->users()->attach($request->user_id, [
            'is_admin' => $request->is_admin,
            'created_at' => now(),
        ]);


        return redirect()->route('users.show', $request->user_id);
    }

    /**
     * Show the form for editing the specified user-server association.
     */
    public function edit(string $users_server)
    {
        [$userId, $serverId] = explode('-', $users_server);
        $server = Server::findOrFail($serverId);
        $user = $server->users()->wherePivot('user_id', $userId)->firstOrFail();
        return view('users_server.edit', compact('server', 'user'));
    }


    /**
     * Update the specified user-server association in storage.
     */
    public function update(UpdateUsersServerRequest $request, string $users_server)
    {
        [$userId, $serverId] = explode('-', $users_server);
        $server = Server::findOrFail($serverId);
        $server->users()->updateExistingPivot($userId, [
            'is_admin' => $request->is_admin,
        ]);

        return redirect()->route('servers.show', $server->id);
    }


    /**
     * Remove the specified user-server association from storage.
     */
    public function destroy(string $users_server)
    {
        [$userId, $serverId] = explode('-', $users_server);
        $server = Server::findOrFail($serverId);
        $server->users()->detach($userId);

        return redirect()->route('servers.show', $server->id);
    }
}
