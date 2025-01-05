@extends('layouts.app')

@section('title', 'Servers')
@section('header-title', 'Server List')

@section('header-buttons')

    <x-conditional-link
        action="create"
        :model="App\Models\Server::class"
        linkClass="button-success"
        href="{{ route('servers.create') }}"
        tooltip="You need to be logged in to create a server."
    >New Server</x-conditional-link>

    <a href="{{ route('users.index') }}" class="button-primary">View All Users</a>
@endsection

@section('content')
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Members</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($servers as $server)
            <tr>
                <td>{{ $server->id }}</td>
                <td>{{ $server->name }}</td>
                <td>{{ $server->users_count }} / {{ $server->capacity }}</td>
                <td><a href="{{ route('servers.show', $server->id) }}" class="button-primary">View Details</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $servers->links() }}
@endsection
