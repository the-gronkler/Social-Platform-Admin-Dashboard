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

    // Show the form to create a new servers
    public function create()
    {
        $this->authorize('create', Server::class);
        return view('servers.create');
    }

    // Store a new servers
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

    // Show details of a specific servers along with associated users
    public function show($id)
    {
        $server = Server::findOrFail($id);
        // Manually authorize the 'view' action
        $this->authorize('view', $server);

        $users = $server->users()->paginate(config('constants.PAGINATION_LIST_LENGTH'));

        return view('servers.show', compact('server', 'users'));
    }

    // Show the form to edit a servers
    public function edit($id)
    {
        $server = Server::findOrFail($id);
        $this->authorize('update', $server);
        return view('servers.edit', compact('server'));
    }

    // Update a specific servers
    public function update(Request $request, Server $server)
    {
        $this->authorize('update', $server);
        // Validate the inputs
        $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => [
                'required',
                'integer',
                'min:1',
                'min:' . $server->users()->count(),
            ],
        ]);

        // Update the server
        $server->update([
            'name' => $request->name,
            'capacity' => $request->capacity,
        ]);

        return redirect()->route('servers.show', $server->id)
            ->with('success', 'Server updated successfully');
    }

    // Delete a specific servers
    public function destroy($id)
    {
        $server = Server::findOrFail($id);
        $this->authorize('delete', $server);
        $server->delete();

        return redirect()->route('servers.index');
    }
}
