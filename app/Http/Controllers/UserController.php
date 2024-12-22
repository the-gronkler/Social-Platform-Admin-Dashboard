<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Display a list of all users
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    // Show the form to create a new user
    public function create()
    {
        return view('users.create');
    }

    // Store a new user
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required',
        ]);

        User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'created_at' => now(),
        ]);

        return redirect()->route('users.index');
    }

    // Show details of a specific user along with associated servers
    public function show($id)
    {
        $user = User::findOrFail($id);
        $servers = $user->servers; // Many-to-many relationship with servers
        return view('users.show', compact('user', 'servers'));
    }

    // Show the form to edit a user
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    // Update a specific user
    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect()->route('users.show', $user->id);
    }

    // Delete a specific user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index');
    }
}
