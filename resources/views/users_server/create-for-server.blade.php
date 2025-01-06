@extends('layouts.app')
@section('title', 'Add Member to Server')
@section('header-title', 'Add User to Server: ' . $server->name)

@section('header-buttons')
    <a href="{{ route('servers.show', $server->id) }}" class="button-primary">Back</a>
@endsection

@section('content')
    <form action="{{ route('users_server.store') }}" method="POST">
        @csrf
        <input type="hidden" name="server_id" value="{{ $server->id }}">

        <x-error-summary />

        <table>
            <tr>
                <th>Server</th>
                <td>{{ '(' . $server->id . ') ' .  $server->name }}</td>
            </tr>
            <tr>
                <th>User</th>
                <td>
                    <select id="user_id" name="user_id" required>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">
                                {{ '(' . $user->id . ') ' .  $user->email }}
                            </option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <th>Is Admin</th>
                <td class="radio-container">
                    <label><input type="radio" name="is_admin" value="1"> Yes</label>
                    <label><input type="radio" name="is_admin" value="0" checked> No</label>
                </td>
            </tr>
        </table>

        <div class="submit-container">
            <x-conditional-button
                action="create"
                :model="App\Models\UsersServer::class"
                cssClass="button-success"
                tooltip="You need admin permissions to create this association."
            >Add User to Server</x-conditional-button>
        </div>
    </form>
@endsection
