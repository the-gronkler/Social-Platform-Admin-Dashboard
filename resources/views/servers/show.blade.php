<!-- resources/views/servers/show.blade.php -->
@extends('layouts.app')

@section('title', 'Server Details')

@section('header-title', 'Server Details')

@section('header-buttons')
    <a href="{{ route('servers.index') }}" class="button-primary">View All Servers</a>

    <x-conditional-link
        action="update"
        :model="$server"
        cssClass="button-edit"
        href="{{ route('servers.edit', $server->id) }}"
        tooltip="You need admin permissions to edit this server."
    >Edit</x-conditional-link>
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
            <td>{{ $server->users->count() }} / {{ $server->capacity }} members</td>
        </tr>
    </table>

    <div class="header-container">
        <h2>Members</h2>
        <a href="{{ route('users_server.create-for-server', $server) }}" class="button-success">Add Member</a>
    </div>

    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Is Admin</th>
            <th>Date Joined</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->pivot->is_admin ? 'Yes' : 'No' }}</td>
                <td>{{ $user->pivot->created_at->format('d.m.Y') }}</td>
                <td>
                    <x-conditional-link
                        action="view"
                        :model="$user"
                        cssClass="button-primary"
                        href="{{ route('users.show', $user->id) }}"
                        tooltip=""
                    >View User</x-conditional-link>

                    @if($user->pivot)
                        @php
                            $server_id = $user->pivot->server_id;
                            $usersServer = App\Models\UsersServer::where('user_id', $user->id)->where('server_id', $server_id)->first();
                            $id = ['users_server' => $user->id . '-' . $server_id]
                        @endphp

                        <x-conditional-link
                            action="view"
                            :model="$usersServer"
                            cssClass="button-primary"
                            href="{{ route('users_server.show', $id) }}"
                            tooltip=""
                        >View Association</x-conditional-link>

                        <x-conditional-link
                            action="update"
                            :model="$usersServer"
                            cssClass="button-edit"
                            href="{{ route('users_server.edit', $id) }}"
                            tooltip=""
                        >Edit Association</x-conditional-link>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
@endsection
