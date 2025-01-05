<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Server;
use App\Models\UsersServer;
use App\Http\Requests\StoreUsersServerRequest;
use App\Http\Requests\UpdateUsersServerRequest;
use Illuminate\Support\Facades\Gate;


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
        $users_server = UsersServer::where('server_id', $serverId)
            ->where('user_id', $userId)
            ->firstOrFail();

        // Authorize view access using the policy
        $this->authorize('view', $users_server);

        return view('users_server.show', compact('server', 'user', 'users_server'));
    }

    /**
     * Show the form for creating a new user-server association for a specific server.
     */
    public function createForServer(Server $server)
    {

        $this->authorize('create', UsersServer::class);

        // select users who are not members for the server
        $users = User::whereDoesntHave('servers',
            fn($query) => $query->where('server_id', $server->id))
            ->get();

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
        // Manually authorize this action using the policy for creating
        $this->authorize('create', UsersServer::class);

        // select servers where the user is not a member
        $servers = Server::whereDoesntHave('users',
            fn($query) => $query->where('user_id', $user->id)
        )
            ->where('capacity', '>', $user->servers->count())
            ->get();

        $errors = [];
        if ($servers->count() === 0) {
            $errors['no_servers'] = 'There are no existing servers you can add this user to ;(';
        }


        return view('users_server.create-for-user', compact('user', 'servers'))
            ->withErrors($errors);
    }


    /**
     * Store a new user-server association.
     */
    public function store(StoreUsersServerRequest $request)
    {
        $this->authorize('create', UsersServer::class);

        // check if an associeatoon with $request->server_id and $request->user_id already exists
        if (UsersServer::where('server_id', $request->server_id)
            ->where('user_id', $request->user_id)
            ->exists()
        ) {
            return redirect()->back()->withErrors([
                'server_id' => 'This user is already a member of this server.',
            ]);
        }

        // check that a space is available in the server
        if (Server::findOrFail($request->server_id)->users->count()
            >= Server::findOrFail($request->server_id)->capacity) {
            return redirect()->back()->withErrors([
                'server_id' => 'The server is full. Cant add members',
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
        $users_server = UsersServer::where('server_id', $serverId)
            ->where('user_id', $userId)
            ->firstOrFail();

        $this->authorize('update', $users_server);

        return view('users_server.edit', compact('server', 'user', 'users_server'));
    }


    /**
     * Update the specified user-server association in storage.
     */
    public function update(UpdateUsersServerRequest $request, string $users_server)
    {
        [$userId, $serverId] = explode('-', $users_server);
        $server = Server::findOrFail($serverId);

        $userServer = UsersServer::where('server_id', $serverId)
            ->where('user_id', $userId)
            ->firstOrFail();

        $this->authorize('update',  $userServer);
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
        $this->authorize('delete', UsersServer::class);
        [$userId, $serverId] = explode('-', $users_server);
        $server = Server::findOrFail($serverId);
        $server->users()->detach($userId);

        return redirect()->route('servers.show', $server->id);
    }
}
