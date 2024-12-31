@extends('layouts.app')

@section('title', 'Users')
@section('header-title', 'User List')

@section('header-buttons')
    <a href="{{ route('users.create') }}" class="button-success">New User</a>
    <a href="{{ route('servers.index') }}" class="button-primary">View All Servers</a>
@endsection

@section('content')
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Role</th>
            <th>Servers Joined</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>{{ $user->servers_count }}</td>
                <td><a href="{{ route('users.show', $user->id) }}" class="button-primary">View Details</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
