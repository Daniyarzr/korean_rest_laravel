<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin')</title>

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <div class="admin">
        <aside class="sidebar">
            <div class="brand">Админка</div>

            <nav class="nav">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">Главная</a>
                <a class="nav-link" href="{{ route('admin.users.index') }}">Пользователи</a>
                <a class="nav-link" href="{{ route('admin.dishes.index') }}">Блюда</a>
            </nav>
        </aside>

        <main class="content">
            @yield('content')
        </main>
    </div>
</body>
</html>
