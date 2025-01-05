@extends('layouts.app')
@section('title', 'User Details')
@section('header-title', 'User Details')

@section('header-buttons')
    <x-conditional-link
        action="viewAny"
        :model="App\Models\User::class"
        cssClass="button-primary"
        href="{{ route('users.index')}}"
        tooltip=""
    >View All Users</x-conditional-link>

    <x-conditional-link
        action="update"
        :model="$user"
        cssClass="button-edit"
        href="{{ route('users.edit', $user->id) }}"
        tooltip="Login as this user or as admin to edit"
    >Edit</x-conditional-link>
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

        <x-conditional-link
            action="create"
            :model="App\Models\UsersServer::class"
            cssClass="button-success"
            href="{{ route('users_server.create_for_user', $user) }}"
            tooltip=""
        >Add to Server</x-conditional-link>
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
                    <x-conditional-link
                        action="view"
                        :model="$server"
                        cssClass="button-primary"
                        href="{{ route('servers.show', $server->id) }}"
                        tooltip=""
                    >View Server</x-conditional-link>

                    @if($server->pivot)
                        @php
                            $usersServer = App\Models\UsersServer::where('user_id', $server->pivot->user_id)
                            ->where('server_id', $server->id)
                            ->first();
                            $id = ['users_server' => $server->pivot->user_id . '-' . $server->id]
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
    {{ $servers->links() }}
@endsection
