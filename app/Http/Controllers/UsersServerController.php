<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Server;
use App\Models\UsersServer;
use Illuminate\Http\Request;
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
        $users = User::all(); // List of users to choose from
        return view('users_server.create-for-server', compact('server', 'users'));
    }


    /**
     * Show the form for creating a new user-server association for a specific user.
     */
    public function createForUser(User $user)
    {
        $servers = Server::all(); // List of servers to choose from
        return view('users_server.create-for-user', compact('user', 'servers'));
    }


    /**
     * Store a new user-server association.
     */
    public function store(StoreUsersServerRequest $request)
    {
        $server = Server::findOrFail($request->server_id);
        $server->users()->attach($request->user_id, [
            'is_admin' => $request->is_admin,
            'created_at' => now(),
        ]);


        return redirect()->route('servers.show', $server->id);
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
