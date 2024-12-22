<?php

namespace App\Http\Controllers;

use App\Models\Server;
use Illuminate\Http\Request;

class ServerController extends Controller
{
    // Display a list of all servers
    public function index()
    {
        $servers = Server::withCount('users')->get();
//        dd($servers);
        return view('servers.index', compact('servers'));
    }

    // Show the form to create a new servers
    public function create()
    {
        return view('servers.create');
    }

    // Store a new servers
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:250',
            'maxcapacity' => 'required|integer|min:1',
        ]);

        Server::create([
            'name' => $request->name,
            'maxcapacity' => $request->maxcapacity,
        ]);

        return redirect()->route('servers.index');
    }

    // Show details of a specific servers along with associated users
    public function show($id)
    {
        $server = Server::findOrFail($id);
        $users = $server->users; // Many-to-many relationship with users
        return view('servers.show', compact('server', 'users'));
    }

    // Show the form to edit a servers
    public function edit($id)
    {
        $server = Server::findOrFail($id);
        return view('servers.edit', compact('server'));
    }

    // Update a specific servers
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:250',
            'maxcapacity' => 'required|integer|min:1',
        ]);

        $server = Server::findOrFail($id);
        $server->update([
            'name' => $request->name,
            'maxcapacity' => $request->maxcapacity,
        ]);

        return redirect()->route('servers.show', $server->id);
    }

    // Delete a specific servers
    public function destroy($id)
    {
        $server = Server::findOrFail($id);
        $server->delete();

        return redirect()->route('servers.index');
    }
}
