@extends('layouts.app')
@section('title', 'Create Server')
@section('header-title', 'Create Server')

@section('header-buttons')
    <a href="{{ route('servers.index') }}" class="button-primary">Back to Servers</a>
@endsection

@section('content')
    <form action="{{ route('servers.store') }}" method="POST">
        @csrf

        <x-error-summary />

        @php
            $minCapacity = 1;

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
                    'label' => 'Capacity',
                    'name' => 'capacity',
                    'id' => 'capacity',
                    'type' => 'number',
                    'attributes' => 'required min="' . $minCapacity . '"',
                    'value' => old('capacity')
                ],
            ];
        @endphp

        <x-editable-table :fields="$fields" />

        <div class="submit-container">
            <x-conditional-button
                action="create"
                :model="App\Models\Server::class"
                cssClass="button-success"
                tooltip="You to log in to create a server."
            >Create Server</x-conditional-button>
        </div>

    </form>
@endsection
