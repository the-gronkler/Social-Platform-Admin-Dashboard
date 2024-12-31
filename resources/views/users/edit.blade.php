@extends('layouts.app')
@section('title', 'Edit User')
@section('header-title', 'Edit User')

@section('header-buttons')
    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="button-danger">Delete</button>

        <a href="{{ route('users.show', $user->id) }}" class="button-primary">Back</a>
    </form>
@endsection

@section('content')
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        @php
            $fields = [
                [
                    'label' => 'ID',
                    'name' => 'id',
                    'id' => 'id',
                    'type' => 'text',
                    'attributes' => 'readonly',
                    'value' => $user->id
                ],
                [
                    'label' => 'Name',
                    'name' => 'name',
                    'id' => 'name',
                    'type' => 'text',
                    'attributes' => 'required',
                    'value' => old('name', $user->name)
                ],
                [
                    'label' => 'Email',
                    'name' => 'email',
                    'id' => 'email',
                    'type' => 'email',
                    'attributes' => 'required',
                    'value' => old('email', $user->email)
                ],
                 [
                    'label' => 'Password',
                    'name' => 'password',
                    'id' => 'password',
                     'type' => 'password',
                    'attributes' => 'minlength="6"',
                    'value' => null
                ],
                [
                     'label' => 'Role',
                     'name' => 'role',
                     'id' => 'role',
                     'type' => 'select',
                     'options' => ['user' => 'User', 'admin' => 'Admin'],
                     'attributes' => 'required',
                     'value' => old('role', $user->role)
                 ],
            ];
        @endphp

        <x-editable-table :fields="$fields" />

        <div class="submit-container">
            <button type="submit" class="button-success">Save Changes</button>
        </div>
    </form>
@endsection
