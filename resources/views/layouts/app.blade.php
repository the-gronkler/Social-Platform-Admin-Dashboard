<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('styles/styles.css') }}">
</head>
<body>

<div class = permanent-header>
<div class="header-container">
    <h1 class="website-title" >Social Platform Admin Dashboard</h1>

    @guest
        <a href="{{ route('register.show') }}" class="button-success">Register</a>
        <a href="{{ route('login.show') }}" class="button-primary">Login</a>
    @endguest
    @auth
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="inline-block">
            @csrf
            <button type="submit" class="button-danger">Logout</button>
        </form>
    @endauth
</div>
</div>

<div class="header-container">
    <h1>@yield('header-title')</h1>
    @yield('header-buttons')
</div>

@yield('content')

<footer style="text-align: center;">
@auth
    <span>Logged in as: {{ Auth::user()->email }}</span>
@endauth
@guest
    <span>Not logged in</span>
@endguest
</footer>
</body>
</html>
