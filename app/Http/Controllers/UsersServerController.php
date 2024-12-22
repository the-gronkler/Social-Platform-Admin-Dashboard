<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Server;
use Illuminate\Http\Request;

class UsersServerController extends Controller
{
    // Display details of a specific user-servers association
    public function show($serverId, $userId)
    {
        $server = Server::findOrFail($serverId);
        $user = $server->users()->wherePivot('user_id', $userId)->firstOrFail();
        return view('users_server.show', compact('server', 'user'));
    }

    // Show the form to create a new user-servers association
    public function createForServer($serverId)
    {
        $server = Server::findOrFail($serverId);
        $users = User::all(); // List of users to choose from
        return view('users_server.create-for-servers', compact('server', 'users'));
    }
    public function createForUser($userId)
    {
        $user = User::findOrFail($userId);
        $servers = Server::all(); // List of servers to choose from
        return view('users_server.create-for-user', compact('user', 'servers'));
    }

    // Store a new user-servers association
    public function store(Request $request)
    {
        $request->validate([
            'server_id' => 'required|exists:servers,id',
            'user_id' => 'required|exists:users,id',
            'isAdmin' => 'required|boolean',
        ]);

        $server = Server::findOrFail($request->server_id);
        $server->users()->attach($request->user_id, [
            'is_admin' => $request->isAdmin,
            'created_at' => now(),
        ]);

        return redirect()->route('servers.show', $server->id);
    }

    // Show the form to edit an existing user-servers association
    public function edit($serverId, $userId)
    {
        $server = Server::findOrFail($serverId);
        $user = $server->users()->wherePivot('user_id', $userId)->firstOrFail();
        return view('users_server.edit', compact('server', 'user'));
    }

    // Update an existing user-servers association
    public function update(Request $request, $serverId, $userId)
    {
        $request->validate([
            'isAdmin' => 'required|boolean',
        ]);

        $server = Server::findOrFail($serverId);
        $server->users()->updateExistingPivot($userId, [
            'is_admin' => $request->isAdmin,
        ]);

        return redirect()->route('servers.show', $server->id);
    }

    // Delete a specific user-servers association
    public function destroy($serverId, $userId)
    {
        $server = Server::findOrFail($serverId);
        $server->users()->detach($userId);

        return redirect()->route('servers.show', $server->id);
    }
}

