@extends('layouts.app')

@section('title', 'Users')
@section('header-title', 'User List')

@section('header-buttons')
    <x-conditional-link
        action="create"
        :model="App\Models\User::class"
        cssClass="button-success"
        href="{{ route('users.create') }}"
        tooltip="You need admin permissions to create a user."
    >New User</x-conditional-link>

{{--    <a href="{{ route('servers.index') }}" class="button-primary">View All Servers</a>--}}

    <x-conditional-link
        action="viewAny"
        :model="App\Models\Server::class"
        cssClass="button-primary"
        href="{{ route('servers.index')}}"
        tooltip=""
    >View All Servers</x-conditional-link>



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
                <td>
                    <x-conditional-link
                        action="view"
                        :model="$user"
                        cssClass="button-primary"
                        href="{{ route('users.show', $user->id) }}"
                        tooltip=""
                    >View Details</x-conditional-link>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
@endsection
