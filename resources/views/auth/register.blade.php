@extends('layouts.app')
@section('title', 'Register')
@section('header-title', 'Register')

@section('header-buttons')
    <a href="{{ route('servers.index') }}" class="button-primary">Main Page</a>
@endsection

@section('content')
    <form method="POST" action="{{ route('register') }}" class="form-container">
        @csrf

        <div class="form-item">
            <label for="name">Name</label>
            <input class="input" id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
            @error('name')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-item">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required>
            @error('email')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-item">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required>
            @error('password')
            <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-item">
            <label for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required>
        </div>

        <div class="submit-container">
            <div></div>
            <button type="submit" class="button-primary">Register</button>
        </div>

    </form>
@endsection
