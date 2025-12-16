@extends('layouts.app')

@section('title', 'Кимчи House | Главная')

@section('content')
<!-- Hero -->
<div class="hero text-center" style="max-height:870px;">
    <div class="container">
        <h1 class="display-3 fw-bold mb-4">Добро пожаловать в Кимчи House</h1>
        <p class="lead mb-5 text-white">Настоящий вкус Кореи — кимчи, пибимпаб, острые супы и многое другое</p>
        <a href="{{route('reservations.create')}}" class="btn btn-danger btn-lg px-5">Забронировать столик</a>
    </div>
</div>

<!-- О ресторане -->
<section class="section about">
    <div class="container about__wrapper">
        <div class="about__text">
            <h2 class="section-title">О нашем ресторане</h2>
            <p>
                Мы — ресторан корейской кухни, где традиционные рецепты сочетаются
                с современным подходом. Мы готовим аутентичные блюда из свежих
                ингредиентов, сохраняя настоящий вкус Кореи.
            </p>
            <p>
                Вы можете прийти к нам в ресторан или заказать любимые блюда
                с доставкой домой.
            </p>
        </div>

        <div class="about__image">
            <img src="/storage/images/about.jpg" alt="Корейская кухня">
        </div>
    </div>
</section>

<!-- Преимущества -->
<section class="section advantages">
    <div class="container">
        <h2 class="section-title center">Наши преимущества</h2>

        <div class="advantages__grid">
            <div class="advantage">
                <h3>Аутентичные рецепты</h3>
                <p>Традиционная корейская кухня и оригинальные специи.</p>
            </div>

            <div class="advantage">
                <h3>Онлайн-заказ</h3>
                <p>Быстрый и удобный заказ еды через сайт.</p>
            </div>

            <div class="advantage">
                <h3>Бронирование столов</h3>
                <p>Забронируйте столик заранее без звонков.</p>
            </div>

            <div class="advantage">
                <h3>Уютная атмосфера</h3>
                <p>Комфортное пространство для встреч и отдыха.</p>
            </div>
        </div>
    </div>
</section>

<!-- Где нас посетить -->
<section class="section visit">
    <div class="container visit__wrapper">
        <div class="visit__image">
            <img src="/storage/images/restaurant.jpg" alt="Интерьер ресторана">
        </div>

        <div class="visit__text">
            <h2 class="section-title">Приходите к нам</h2>
            <p>
                Мы будем рады видеть вас в нашем ресторане. Приходите на обед,
                ужин или забронируйте столик для особого вечера.
            </p>

            <ul class="visit__info">
                <li><strong>Адрес:</strong> г. Москва, ул. Пушкина, 10</li>
                <li><strong>Время работы:</strong> ежедневно 11:00 – 23:00</li>
            </ul>

            <a href="/reservation" class="btn-primary">Забронировать столик</a>
        </div>
    </div>
</section>

<!-- Популярные блюда -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">Популярные блюда</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($popularDishes as $dish)
                <div class="col">
                    <div class="card h-100 shadow dish-card">
                        @if($dish->url_image)
                            <img src="{{ asset('storage/' . $dish->url_image) }}" class="card-img-top" alt="{{ $dish->name }}">
                        @else
                            <img src="https://via.placeholder.com/400x300?text=Блюдо" class="card-img-top" alt="{{ $dish->name }}">
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $dish->name }}</h5>
                            <p class="card-text flex-grow-1">{{ Str::limit($dish->description, 80) }}</p>
                            
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div style="width:80%;margin:0 auto;"class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="h5 mb-0 text-danger">{{ $dish->price }} ₽</span>
                                    
                                    {{-- Добавляем кнопку корзины --}}
                                    <form action="{{ route('cart.add', $dish) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm rounded-pill">
                                            <i class="bi bi-cart-plus"></i> В корзину
                                        </button>
                                    </form>
                                </div>
            
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="text-center mt-5">
            <a href="/menu" class="btn btn-outline-danger btn-lg">Смотреть полное меню</a>
        </div>
    </div>
</section>
@endsection