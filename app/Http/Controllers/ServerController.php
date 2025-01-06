<?php

namespace App\Http\Controllers;

use App\Models\Server;
use Illuminate\Http\Request;

class ServerController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Server::class);

        $servers = Server::withCount('users')
            ->paginate(config('constants.PAGINATION_LIST_LENGTH'));

        return view('servers.index', compact('servers'));
    }

    public function create()
    {
        $this->authorize('create', Server::class);
        return view('servers.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Server::class);

        $request->validate([
            'name' => 'required|max:250',
            'capacity' => 'required|integer|min:1',
        ]);

        Server::create([
            'name' => $request->name,
            'capacity' => $request->capacity,
        ]);

        return redirect()->route('servers.index');
    }

    public function show($id)
    {
        $server = Server::findOrFail($id);

        $this->authorize('view', $server);

        $users = $server->users()->paginate(config('constants.PAGINATION_LIST_LENGTH'));

        return view('servers.show', compact('server', 'users'));
    }

    public function edit($id)
    {
        $server = Server::findOrFail($id);
        $this->authorize('update', $server);
        return view('servers.edit', compact('server'));
    }

    public function update(Request $request, Server $server)
    {
        $this->authorize('update', $server);

        $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => [
                'required',
                'integer',
                'min:1',
                'min:' . $server->users()->count(),
            ],
        ]);

        $server->update([
            'name' => $request->name,
            'capacity' => $request->capacity,
        ]);

        return redirect()->route('servers.show', $server->id)
            ->with('success', 'Server updated successfully');
    }

    public function destroy($id)
    {
        $server = Server::findOrFail($id);
        $this->authorize('delete', $server);
        $server->delete();

        return redirect()->route('servers.index');
    }
}
