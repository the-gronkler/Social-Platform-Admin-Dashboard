@extends('layouts.app')
@section('title', 'Edit Server')
@section('header-title', 'Edit Server')

@section('header-buttons')
    <form action="{{ route('servers.destroy', $server->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <a type="submit" class="button-delete">Delete</a>
    </form>
    <a href="{{ route('servers.show', $server->id) }}" class="button-primary">Back</a>
@endsection

@section('content')
    <form action="{{ route('servers.update', $server->id) }}" method="POST">
        @csrf
        @method('PUT')

        @php
            $fields = [
                ['label' => 'ID', 'name' => 'id', 'type' => 'text', 'readonly' => true, 'value' => $server->id],
                ['label' => 'Name', 'name' => 'name', 'type' => 'text', 'readonly' => false, 'value' => old('name', $server->name)],
                ['label' => 'Capacity', 'name' => 'capacity', 'type' => 'number', 'readonly' => false, 'value' => old('capacity', $server->capacity), 'attributes' => ['min' => 1]],
            ];
        @endphp


        <x-editable-table :fields="$fields" />

        <div class="submit-container">
            <button type="submit" class="button-success">Save Changes</button>
        </div>
    </form>
@endsection
