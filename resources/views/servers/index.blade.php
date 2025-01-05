@extends('layouts.app')

@section('title', 'Servers')
@section('header-title', 'Server List')

@section('header-buttons')

    <x-conditional-link
        action="create"
        :model="App\Models\Server::class"
        cssClass="button-success"
        href="{{ route('servers.create') }}"
        tooltip="You need to be logged in to create a server."
    >New Server</x-conditional-link>

    <x-conditional-link
        action="viewAny"
        :model="App\Models\User::class"
        cssClass="button-primary"
        href="{{ route('users.index') }}"
        tooltip=""
    >View All Users</x-conditional-link>
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
                <td>
                    <x-conditional-link
                        action="view"
                        :model="$server"
                        cssClass="button-primary"
                        href="{{ route('servers.show', $server) }}"
                        tooltip=""
                    >View Details</x-conditional-link>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $servers->links() }}
@endsection
