<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Server;
use App\Models\UsersServer;
use App\Http\Requests\StoreUsersServerRequest;
use App\Http\Requests\UpdateUsersServerRequest;


class UsersServerController extends Controller
{
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

    public function createForServer(Server $server)
    {
        $this->authorize('create', UsersServer::class);

        // select users who are not members of this server
        $users = User::whereDoesntHave('servers',
            fn($query) => $query->where('server_id', $server->id))
            ->get();

        $errors = [];
        if ($users->count() === 0)
            $errors['no_users'] = 'There are no existing users you can add to this server.';
        // check capacity
        if ($server->users->count() >= $server->capacity)
            $errors['capacity'] = 'The server is full. Cant add members';

        return view('users_server.create-for-server', compact('server', 'users'))
            ->withErrors($errors);
    }

    public function createForUser(User $user)
    {
        $this->authorize('create', UsersServer::class);

//        $servers = Server::whereDoesntHave('users',
//            fn($query) => $query->where('user_id', $user->id)
//        )
//            ->where('capacity', '>', $user->servers->count())
//            ->get();

        $servers = Server::where(function ($query) use ($user) {
            // Filter out servers the user is already in
            $query->whereNotExists(function ($subquery) use ($user) {
                $subquery->selectRaw(1)
                    ->from('users_server')
                    ->whereColumn('users_server.server_id', 'servers.id')
                    ->where('users_server.user_id', $user->id);
            });
        }) // only select non-full servers
        ->whereRaw('servers.capacity > (
                SELECT COUNT(*) FROM users_server
                WHERE users_server.server_id = servers.id
            )')
            ->get();

        $errors = [];
        if ($servers->count() === 0)
            $errors['no_servers'] = 'There are no existing servers  to which you can add this user :(';

        return view('users_server.create-for-user', compact('user', 'servers'))
            ->withErrors($errors);
    }

    public function store(StoreUsersServerRequest $request)
    {
        $this->authorize('create', UsersServer::class);

        // check if the user is already a member of this server
        if (UsersServer::where('server_id', $request->server_id)
            ->where('user_id', $request->user_id)
            ->exists()
        ) {
            return redirect()->back()->withErrors([
                'server_id' => 'This user is already a member of this server.',
            ]);
        }

        // Check that the server is not full, and can accept another member
        $server = Server::findOrFail($request->server_id);

        $serverMembersCount = $server->users->count();
        $serverCapacity = $server->capacity;

        if ($serverMembersCount >= $serverCapacity)
            return redirect()->back()->withErrors([
                'server_id' => 'The server is full. Cant add members',
            ]);

        $server->users()->attach($request->user_id, [
            'is_admin' => $request->is_admin,
            'created_at' => now(),
        ]);


        return redirect()->route('users_server.show', [
            'users_server' => $request->user_id . '-' . $request->server_id,
        ]);
    }

    public function edit(string $users_server)
    {
        [$userId, $serverId] = explode('-', $users_server);
        // get models
        $server = Server::findOrFail($serverId);
        $user = $server->users()->wherePivot('user_id', $userId)->firstOrFail();
        $users_server = UsersServer::where('server_id', $serverId)
            ->where('user_id', $userId)
            ->firstOrFail();

        $this->authorize('update', $users_server);

        return view(
            'users_server.edit',
            compact('server', 'user', 'users_server')
        );
    }

    public function update(UpdateUsersServerRequest $request, string $users_server)
    {
        [$userId, $serverId] = explode('-', $users_server);

        $server = Server::findOrFail($serverId);
        $userServer = UsersServer::where('server_id', $serverId)
            ->where('user_id', $userId)
            ->firstOrFail();

        $this->authorize('update', $userServer);

        $rowsAffected = $server->users()->updateExistingPivot($userId, [
            'is_admin' => $request->is_admin,
        ]);

        if ($rowsAffected === 0) {
            return redirect()->back()->withErrors([
                'update' => 'There was an error when updating the association.',
            ]);
        }

        return redirect()->route('servers.show', $server->id);
    }

    public function destroy(string $users_server)
    {
        $this->authorize('delete', UsersServer::class);
        [$userId, $serverId] = explode('-', $users_server);

        $server = Server::findOrFail($serverId);

        $server->users()->detach($userId);

        return redirect()->route('servers.show', $server->id);
    }
}
