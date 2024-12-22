<!-- resources/views/servers/show.blade.php -->
@extends('layouts.app')

@section('title', 'Server Details')

@section('header-title', 'Server Details')

@section('header-buttons')
    <a href="{{ route('servers.index') }}" class="button-primary">View All Servers</a>
    <a href="{{ route('servers.edit', $server->id) }}" class="button-edit">Edit</a>
@endsection

@section('content')
    <table>
        <tr>
            <th>ID</th>
            <td>{{ $server->id }}</td>
        </tr>
        <tr>
            <th>Name</th>
            <td>{{ $server->name }}</td>
        </tr>
        <tr>
            <th>Capacity</th>
            <td>{{ $server->users->count() }} / {{ $server->maxCapacity }} members</td>
        </tr>
    </table>

    <div class="header-container">
        <h2>Members</h2>
        <a href="{{ route('users_server.create-for-server', $server) }}" class="button-success">Add Member</a>
    </div>

    <table>
        <thead>
        <tr>
            <th>Email</th>
            <th>Is Admin</th>
            <th>Date Joined</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($server->users as $user)
            <tr>
                <td>{{ $user->email }}</td>
                <td>{{ $user->pivot->is_admin ? 'Yes' : 'No' }}</td>
                <td>{{ $user->pivot->created_at->format('d.m.Y') }}</td>
                <td>
                    <a href="{{ route('users.show', $user->id) }}" class="button-primary">View User</a>
                    <a href="{{ route('users_server.show', ['users_server' => $user->pivot->user_id . '-' . $server->id]) }}" class="button-primary">View Association</a>
                    <a href="{{ route('users_server.edit', ['users_server' => $user->pivot->user_id . '-' . $server->id]) }}" class="button-edit">Edit Association</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
