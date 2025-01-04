@extends('layouts.app')
@section('title', 'User Details')
@section('header-title', 'User Details')

@section('header-buttons')
    <a href="{{ route('users.index') }}" class="button-primary">View All Users</a>
    <a href="{{ route('users.edit', $user->id) }}" class="button-edit">Edit</a>
@endsection

@section('content')
    <table>
        <tr>
            <th>ID</th>
            <td>{{ $user->id }}</td>
        </tr>
        <tr>
            <th>Name</th>
            <td>{{ $user->name }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $user->email }}</td>
        </tr>
        <tr>
            <th>Role</th>
            <td>{{ $user->role }}</td>
        </tr>
    </table>

    <div class="header-container">
        <h2>Servers</h2>
        <a href="{{ route('users_server.create_for_user', $user) }}" class="button-success">Add to Server</a>
    </div>

    <table>
        <thead>
        <tr>

            <th>ID</th>
            <th>Server Name</th>
            <th>Is Admin</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($servers as $server)
            <tr>
                <td>{{ $server->id }}</td>
                <td>{{ $server->name }}</td>
                <td>{{ $server->pivot->is_admin ? 'Yes' : 'No' }}</td>
                <td>
                    <a href="{{ route('servers.show', $server->id) }}" class="button-primary">View Server</a>
                    <a href="{{ route('users_server.show', ['users_server' => $user->id . '-' . $server->id]) }}" class="button-primary">View Association</a>
                    <a href="{{ route('users_server.edit', ['users_server' => $user->id . '-' . $server->id]) }}" class="button-edit">Edit Association</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $servers->links() }}
@endsection
