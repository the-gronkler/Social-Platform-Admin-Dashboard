@extends('layouts.app')
@section('title', 'User-Server Association')
@section('header-title', 'User-Server Association')

@section('header-buttons')
    <a href="{{ route('servers.show', $server->id) }}" class="button-primary">Back</a>
    <a href="{{ route('users_server.edit', $user->id . '-' . $server->id) }}" class="button-edit">Edit Association</a>
@endsection

@section('content')
    <table>
        <tr>
            <th>User</th>
            <td>{{ $user->email }}</td>
            <td>
                <a href="{{ route('users.show', $user->id) }}" class="button-primary">View User</a>
            </td>
        </tr>
        <tr>
            <th>Server</th>
            <td>{{ $server->name }}</td>
            <td>
                <a href="{{ route('servers.show', $server->id) }}" class="button-primary">View Server</a>
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
