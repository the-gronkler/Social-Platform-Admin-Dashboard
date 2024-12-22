<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('styles/styles.css') }}">
</head>
<body>

<div class="header-container">
    <h1>@yield('header-title')</h1>
    @yield('header-buttons')
</div>

@yield('content')

</body>
</html>
