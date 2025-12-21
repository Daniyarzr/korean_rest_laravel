<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('storage/images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage/images/favicon-16x16.png') }}">
    <title>@yield('title', config('app.name', 'Кимчи House'))</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">    
   <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <style>
    
        .alert-notification {
            position: fixed;
            top: 80px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            max-width: 400px;
            border-radius: 12px;
            border: none;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
            animation: slideInRight 0.5s ease-out, fadeOut 0.5s ease-in 4.5s forwards;
            overflow: hidden;
        }
        
        /* Цветные полоски слева */
        .alert-notification::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 6px;
            border-radius: 12px 0 0 12px;
        }
        
        .alert-success::before {
            background: linear-gradient(to bottom, #198754, #0f5132);
        }
        
        .alert-danger::before,
        .alert-error::before {
            background: linear-gradient(to bottom, #dc3545, #842029);
        }
        
        .alert-warning::before {
            background: linear-gradient(to bottom, #ffc107, #664d03);
        }
        
        .alert-info::before {
            background: linear-gradient(to bottom, #0dcaf0, #055160);
        }
        
        /* Градиентные фоны */
        .alert-success {
            background: linear-gradient(135deg, #d1e7dd 0%, #badbcc 100%);
            color: #0f5132;
        }
        
        .alert-danger,
        .alert-error {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c2c7 100%);
            color: #842029;
        }
        
        .alert-warning {
            background: linear-gradient(135deg, #fff3cd 0%, #ffecb5 100%);
            color: #664d03;
        }
        
        .alert-info {
            background: linear-gradient(135deg, #cff4fc 0%, #b6effb 100%);
            color: #055160;
        }
        
        /* Анимации */
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: translateX(0);
            }
            to {
                opacity: 0;
                transform: translateX(100%);
                display: none;
            }
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }
        
        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
            }
        }
        
        /* Эффекты при наведении */
        .alert-notification:hover {
            animation-play-state: paused;
            transform: translateX(-5px);
            transition: transform 0.3s;
        }
        
        /* Иконки */
        .alert-icon {
            font-size: 1.5rem;
            margin-right: 12px;
            animation: bounce 1s infinite;
        }
        
        .alert-success .alert-icon {
            color: #198754;
        }
        
        .alert-danger .alert-icon,
        .alert-error .alert-icon {
            color: #dc3545;
        }
        
        .alert-warning .alert-icon {
            color: #ffc107;
        }
        
        .alert-info .alert-icon {
            color: #0dcaf0;
        }
        
        /* Кнопка закрытия */
        .alert-close-btn {
            color: inherit;
            opacity: 0.7;
            transition: opacity 0.3s;
            background: none;
            border: none;
            padding: 0;
        }
        
        .alert-close-btn:hover {
            opacity: 1;
        }
        
        /* Для важных сообщений - мигание */
        .alert-important {
            animation: slideInRight 0.5s ease-out, pulse 2s infinite;
        }
        
        /* Герой и карточки блюд (ваши старые стили) */
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
</head>
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
                    <li class="nav-item"><a class="nav-link" href="{{route ('contacts.index')}}">Контакты</a></li>
                    @auth
                    <li class="nav-item"><a class="nav-link" href="{{route ('reservations.create')}}">Бронь</a></li>
                    @endauth
                    @guest
                     <li class="nav-item"><a class="nav-link" id="bookTableGuestBtn" href="{{route ('reservations.create')}}">Бронь</a></li>
                    @endguest
                </ul>
                
                <!-- Корзина -->
                <a href="{{ route('cart.index') }}" 
                   class="btn btn-outline-danger position-relative rounded-pill me-3">
                    <i class="bi bi-cart3"></i>
                    @if(session('cart_count', 0) > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ session('cart_count', 0) }}
                        </span>
                    @endif
                </a>
                
                <!-- Авторизация -->
                @auth
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile.index') }}">Личный кабинет</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Выход</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <div class="d-flex gap-2">
                        <a class="btn btn-outline-light btn-sm" href="{{ route('login') }}">Вход</a>
                        @if(Route::has('register'))
                            <a class="btn btn-danger btn-sm" href="{{ route('register') }}">Регистрация</a>
                        @endif
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Уведомления (фиксированные) -->
    <div class="alerts-container">
        @if(session('success'))
            <div class="alert alert-success alert-notification d-flex align-items-center" role="alert">
                <i class="bi bi-check-circle-fill alert-icon"></i>
                <div class="flex-grow-1">
                    <strong class="d-block mb-1">Успешно!</strong>
                    <span class="small">{{ session('success') }}</span>
                </div>
                <button type="button" class="alert-close-btn" data-bs-dismiss="alert">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        @endif
        
        @if(session('error') || session('danger'))
            <div class="alert alert-danger alert-notification d-flex align-items-center" role="alert">
                <i class="bi bi-x-circle-fill alert-icon"></i>
                <div class="flex-grow-1">
                    <strong class="d-block mb-1">Ошибка!</strong>
                    <span class="small">{{ session('error') ?? session('danger') }}</span>
                </div>
                <button type="button" class="alert-close-btn" data-bs-dismiss="alert">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        @endif
        
        @if(session('warning'))
            <div class="alert alert-warning alert-notification d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill alert-icon"></i>
                <div class="flex-grow-1">
                    <strong class="d-block mb-1">Внимание!</strong>
                    <span class="small">{{ session('warning') }}</span>
                </div>
                <button type="button" class="alert-close-btn" data-bs-dismiss="alert">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        @endif
        
        @if(session('info'))
            <div class="alert alert-info alert-notification d-flex align-items-center" role="alert">
                <i class="bi bi-info-circle-fill alert-icon"></i>
                <div class="flex-grow-1">
                    <strong class="d-block mb-1">Информация</strong>
                    <span class="small">{{ session('info') }}</span>
                </div>
                <button type="button" class="alert-close-btn" data-bs-dismiss="alert">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        @endif
    </div>

    <!-- Основной контент -->
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
    
    <script>
    
    document.addEventListener('DOMContentLoaded', function() {
        // Закрытие по клику на кнопку
        document.querySelectorAll('.alert-close-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var alert = this.closest('.alert-notification');
                if (alert) {
                    alert.style.animation = 'fadeOut 0.5s ease-in forwards';
                    setTimeout(function() {
                        alert.remove();
                    }, 500);
                }
            });
        });
        
        setTimeout(function() {
            document.querySelectorAll('.alert-notification').forEach(function(alert) {
                alert.style.animation = 'fadeOut 0.5s ease-in forwards';
                setTimeout(function() {
                    alert.remove();
                }, 500);
            });
        }, 5000);
        
     const bookTableGuestBtn = document.getElementById('bookTableGuestBtn');
    if (bookTableGuestBtn) {
        bookTableGuestBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Создаем уведомление
            const notification = document.createElement('div');
            notification.className = 'alert alert-warning alert-notification d-flex align-items-center';
            notification.setAttribute('role', 'alert');
            notification.innerHTML = `
                <i class="bi bi-exclamation-triangle-fill alert-icon"></i>
                <div class="flex-grow-1">
                    <strong class="d-block mb-1">Требуется авторизация</strong>
                    <span class="small">Пожалуйста, войдите или зарегистрируйтесь, чтобы забронировать столик</span>
                </div>
                <button type="button" class="alert-close-btn">
                    <i class="bi bi-x-lg"></i>
                </button>
            `;
            
            // Добавляем уведомление в контейнер
            const alertsContainer = document.querySelector('.alerts-container');
            if (alertsContainer) {
                alertsContainer.appendChild(notification);
                
                // Добавляем обработчик закрытия для новой кнопки
                const closeBtn = notification.querySelector('.alert-close-btn');
                closeBtn.addEventListener('click', function() {
                    notification.style.animation = 'fadeOut 0.5s ease-in forwards';
                    setTimeout(function() {
                        notification.remove();
                    }, 500);
                });
                
                // Автоматическое закрытие через 5 секунд
                setTimeout(function() {
                    notification.style.animation = 'fadeOut 0.5s ease-in forwards';
                    setTimeout(function() {
                        notification.remove();
                    }, 500);
                }, 5000);
                
                // Перенаправление на страницу входа при клике на уведомление
                notification.addEventListener('click', function(e) {
                    if (!e.target.closest('.alert-close-btn')) {
                        window.location.href = "{{ route('login') }}";
                    }
                });
            }
        });
    }
});
 
    
</script>


</body>
</html>