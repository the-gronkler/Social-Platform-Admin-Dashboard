@extends('layouts.app')
@section('title', 'Add User to Server')
@section('header-title', 'Add User to Server: ' . $user->email)


@section('header-buttons')
    <a href="{{ route('users.show', $user->id) }}" class="button-primary">Back</a>
@endsection

@section('content')
    <form action="{{ route('users_server.store') }}" method="POST">
        @csrf
        <input type="hidden" name="user_id" value="{{ $user->id }}">
        @php
            $fields = [
             [
                 'label' => 'Server',
                 'name' => 'server_id',
                 'id' => 'server_id',
                 'type' => 'select',
                 'options' => $servers->pluck('name', 'id')->toArray(),
                  'attributes' => 'required',
              ],
                [
                    'label' => 'Is Admin',
                    'name' => 'is_admin',
                     'id' => 'is_admin',
                    'type' => 'radio',
                     'options' => [1 => 'Yes', 0 => 'No'],
                    'attributes' => 'required',
                 ],
            ];
        @endphp

        <x-editable-table :fields="$fields" />

        <div class="submit-container">
            <button type="submit" class="button-success">Save Changes</button>
        </div>
    </form>
@endsection
