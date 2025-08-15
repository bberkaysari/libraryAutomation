<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kullanıcı Paneli')</title>
</head>
<body>
    <header>
        <h1>Kullanıcı Paneli</h1>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>&copy; 2024</p>
    </footer>
</body>
</html>
