@extends('layouts.app')
@section('title', 'Add User to Server')
@section('header-title', 'Add User ' . $user->email .' to Server')


@section('header-buttons')
    <a href="{{ route('users.show', $user->id) }}" class="button-primary">Back to Users</a>
@endsection

@section('content')
    <form action="{{ route('users_server.store') }}" method="POST">
        @csrf
        <input type="hidden" name="user_id" value="{{ $user->id }}">
        <table>
            <tr>
                <th>User</th>
                <td>{{ '(' . $user->id . ') ' .  $user->email }}</td>
            </tr>
            <tr>
                <th>Server</th>
                <td>
                    <select id="server_id" name="server_id" required>
                        @foreach($servers as $server)
                            <option value="{{ $server->id }}">
                                {{ '(' . $server->id . ') ' .  $server->name }}
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

        <div style="width: 80%;">
        @if ($errors->any())
            <div class="error-summary">
                <ul class="error-summary">
                    @foreach ($errors->all() as $error)
                        <li class="error-summary">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        </div>


        <div class="submit-container">
{{--            <button type="submit" class="button-success">Save Changes</button>--}}
            <x-conditional-button
                action="create"
                :model="App\Models\UsersServer::class"
                cssClass="button-success"
                tooltip="You need admin permissions to create this association."
            >Add User to Server</x-conditional-button>

        </div>
    </form>
@endsection
