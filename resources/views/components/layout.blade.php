
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'My Cool App' }}</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
<header class="header-container">
    <h1>{{ $header ?? 'MY COOL APP' }}</h1>
    {{ $buttons }}
</header>
<main>
    {{ $slot }}
</main>
</body>
</html>
