@extends('layouts.app')
@section('title', 'Create User')
@section('header-title', 'Create User')

@section('header-buttons')
    <a href="{{ route('users.index') }}" class="button-primary">Back to Users</a>
@endsection

@section('content')
    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        @php
            $fields = [
                [
                    'label' => 'Name',
                    'name' => 'name',
                    'id' => 'name',
                    'type' => 'text',
                    'attributes' => 'required',
                    'value' => old('name')
                ],
                [
                    'label' => 'Email',
                    'name' => 'email',
                    'id' => 'email',
                    'type' => 'email',
                    'attributes' => 'required',
                    'value' => old('email')
                ],
                [
                    'label' => 'Password',
                    'name' => 'password',
                    'id' => 'password',
                    'type' => 'password',
                    'attributes' => 'required minlength="6"',
                     'value' => null
                ],
                [
                    'label' => 'Role',
                    'name' => 'role',
                    'id' => 'role',
                    'type' => 'select',
                    'options' => ['user' => 'User', 'admin' => 'Admin'],
                    'attributes' => 'required',
                     'value' => old('role', 'user') // Default to 'user'
                ],
            ];
        @endphp
        <x-editable-table :fields="$fields" />

        <div class="submit-container">
            <button type="submit" class="button-success">Create User</button>
        </div>
    </form>
@endsection
