<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
    
    <style>
        .hero {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('{{ asset('storage/images/hero.jpg') }}') center/cover no-repeat;
            height: 90vh;
            min-height: 600px;
            display: flex;
            align-items: center;
            color: white;
        }
        .dish-card img {
            height: 200px;
            object-fit: cover;
        }
        .spicy { color: #dc3545; }
        .veg   { color: #28a745; }
    </style>
<body>

    <!-- Навигация -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">Кимчи House</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Главная</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('menu.index') }}">Меню</a></li>
                    <li class="nav-item"><a class="nav-link" href="#reservation">Бронь</a></li>
                </ul>
                
                <!-- Правая часть навигации -->
                <ul class="navbar-nav ms-auto">
                    @auth
                        <!-- Пользователь авторизован -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('home') }}">Личный кабинет</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Выход
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <!-- Пользователь не авторизован -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Вход</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Регистрация</a>
                            </li>
                        @endif
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- Футер -->
    <footer class="bg-dark text-white py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Кимчи House</h5>
                    <p>Настоящая корейская кухня в сердце города</p>
                </div>
                <div class="col-md-4">
                    <h5>Часы работы</h5>
                    <p>Пн–Чт: 11:00 – 23:00<br>Пт–Вс: 11:00 – 00:00</p>
                </div>
                <div class="col-md-4">
                    <h5>Контакты</h5>
                    <p>+7 (999) 123-45-67<br>info@kimchihouse.ru</p>
                </div>
            </div>
            <hr>
            <p class="text-center mb-0">© 2025 Кимчи House. Все права защищены.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>