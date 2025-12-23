<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin')</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('storage/images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage/images/favicon-16x16.png') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">  
</head>
<body>
    <div class="admin">
        <aside class="sidebar">
            <div class="brand">Админ Панель</div>

            <nav class="nav">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">Главная</a>
                <a class="nav-link" href="{{ route('admin.users.index') }}">Пользователи</a>
                <a class="nav-link" href="{{ route('admin.dishes.index') }}">Блюда</a>
                <a style="color:red;" class="nav-link" href="{{ route('profile.index') }}"><i class="bi bi-arrow-bar-left"></i>В личный кабинет</a>
            </nav>
        </aside>

        <main class="content">
            @yield('content')
        </main>
    </div>
</body>
</html>
