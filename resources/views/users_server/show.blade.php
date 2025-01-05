@extends('layouts.app')
@section('title', 'User-Server Association')
@section('header-title', 'User-Server Association')

@section('header-buttons')
    <a href="{{ route('servers.show', $server->id) }}" class="button-primary">Back</a>

    <x-conditional-link
        :model="$users_server"
        action="update"
        cssClass="button-edit"
        href="{{ route('users_server.edit', $user->id . '-' . $server->id) }}"
        tooltip="You need admin permissions to edit this association."
    >Edit Association</x-conditional-link>

@endsection

@section('content')
    <table>
        <tr>
            <th>User</th>
            <td>{{ $user->email }}</td>
            <td>
{{--                <a href="{{ route('users.show', $user->id) }}" class="button-primary">View User</a>--}}
                <x-conditional-link
                    action="view"
                    :model="$user"
                    cssClass="button-primary"
                    href="{{ route('users.show', $user->id) }}"
                    tooltip=""
                >View User</x-conditional-link>
            </td>
        </tr>
        <tr>
            <th>Server</th>
            <td>{{ $server->name }}</td>
            <td>
{{--                <a href="{{ route('servers.show', $server->id) }}" class="button-primary">View Server</a>--}}
                <x-conditional-link
                    action="view"
                    :model="$server"
                    cssClass="button-primary"
                    href="{{ route('servers.show', $server->id) }}"
                    tooltip=""
                >View Server</x-conditional-link>
            </td>
        </tr>
        <tr>
            <th>Is Admin</th>
            <td> {{ $user->pivot->is_admin ? 'Yes' : 'No' }} </td>
            <td></td>
        </tr>
        <tr>
            <th>Created At</th>
            <td>{{ $user->pivot->created_at }}</td>
            <td></td>
        </tr>
    </table>
@endsection
