@extends('layouts.app')
@section('title', 'Edit Server')
@section('header-title', 'Edit Server')

@section('header-buttons')
    <form action="{{ route('servers.destroy', $server->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="button-danger">Delete</button>

        <a href="{{ route('servers.show', $server->id) }}" class="button-primary">Back</a>
    </form>

@endsection

@section('content')
    <form action="{{ route('servers.update', $server->id) }}" method="POST">
        @csrf
        @method('PUT')

        @php
            // Calculate the minimum value for capacity
            $minCapacity = max(1, $server->users()->count());

            $fields = [
                [
                    'label' => 'ID',
                    'name' => 'id', // Explicitly provide name, id, and type
                    'id' => 'id',
                    'type' => 'text',
                    'attributes' => 'readonly',
                    'value' => $server->id
                ],
                [
                    'label' => 'Name',
                    'name' => 'name',
                    'id' => 'name',
                    'type' => 'text',
                    'attributes' => 'required',
                    'value' => old('name', $server->name)
                ],
                [
                    'label' => 'Capacity',
                    'name' => 'capacity',
                    'id' => 'capacity',
                    'type' => 'number',
                    'attributes' => 'required min="' . $minCapacity . '"',
                    'value' => old('capacity', $server->capacity)
                ],
            ];
        @endphp

        <x-editable-table :fields="$fields" />

        <div class="submit-container">
            <button type="submit" class="button-success">Save Changes</button>
        </div>
    </form>
@endsection
