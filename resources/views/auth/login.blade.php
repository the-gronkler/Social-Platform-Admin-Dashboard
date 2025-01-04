@extends('layouts.app')
@section('title', 'Login')
@section('header-title', 'Login')

@section('header-buttons')
    <a href="{{ route('servers.index') }}" class="button-primary">Main Page</a>
@endsection

@section('content')
    <div class="header-container">
        <form method="POST" action="{{ route('login') }}" class="form-container">
            @csrf

            <div class="form-item">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
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

            <div class="checkbox-container">
                <label for="remember">Remember Me</label>
                <input type="checkbox" name="remember" id="remember">
            </div>


            <div class="submit-container">
                <button type="submit" class="button-primary">Login</button>
            </div>
        </form>
    </div>
@endsection
