@extends('layouts.app')
@section('title', 'Edit User-Server Association')
@section('header-title', 'Edit User-Server Association')

@section('header-buttons')
    <form action="{{ route('users_server.destroy', $user->id . '-' . $server->id) }}" method="POST">
        @csrf
        @method('DELETE')
{{--        <button type="submit" class="button-danger">Delete Association</button>--}}
        <x-conditional-button
            action="delete"
            :model="$users_server"
            cssClass="button-danger"
            tooltip="You need admin permissions to delete this association."
        >Delete Association</x-conditional-button>

        <a href="{{ route('servers.show', $server->id) }}" class="button-primary">Back</a>
    </form>
@endsection

@section('content')
    <form action="{{ route('users_server.update', $user->id . '-' . $server->id ) }}" method="POST">
        @csrf
        @method('PUT')

        <x-error-summary />

        <table>
            <tr>
                <th>Current User</th>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <th>Current Server</th>
                <td>{{ $server->name }}</td>
            </tr>
            <tr>
                <th>Is Admin</th>
                <td class="radio-container">
                    <label><input type="radio" name="is_admin" value="1" {{ $user->pivot->is_admin ? 'checked' : '' }}> Yes</label>
                    <label><input type="radio" name="is_admin" value="0" {{ !$user->pivot->is_admin ? 'checked' : '' }}> No</label>
                </td>
            </tr>
        </table>
        <div class="submit-container">
            <x-conditional-button
                action="update"
                :model="$users_server"
                cssClass="button-success"
                tooltip="You need admin permissions to update this association."
            >Save Changes</x-conditional-button>
        </div>
    </form>
@endsection
