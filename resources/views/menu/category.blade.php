@extends('layouts.app')

@section('title', $category->name)
<style>
    .hover-shadow:hover { 
        transform: translateY(-5px); 
        box-shadow: 0 10px 20px rgba(0,0,0,0.15)!important; 
    }
    .transition { 
        transition: all 0.3s ease; 
    }
    .form-search-menu {
    width: 40%;
    }
</style>
@section('content')
<div class="container py-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show text-center rounded-pill" role="alert" style="position:fixed; top:75px; right: 40; z-index:100; max-width: 500px; margin: 0 auto 30px;">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    <!-- Заголовок -->
    <h1 class="text-center mb-5 display-5 fw-bold">{{ $category->name }}</h1>
    
    @if($category->description)
        <p class="lead text-muted text-center mb-5">{{ $category->description }}</p>
    @endif

        <!-- Форма поиска -->
    <div class="form-search-menu text-center mb-5 ms-auto me-auto">
        <form action="{{ route('menu.category', $category->slug) }}" method="GET" class="d-inline-block w-100" style="max-width: 500px;">
            <div class="position-relative">
                <input type="text" 
                    class="form-control rounded-pill py-3 px-4 border-danger" 
                    name="search" 
                    placeholder="Поиск в категории {{ $category->name }}..."
                    value="{{ $search ?? '' }}">
                <button type="submit" class="btn btn-danger rounded-pill position-absolute end-0 top-0 bottom-0 m-1 px-4">
                    Найти
                </button>
            </div>
        </form>
    </div>

    <!-- Кнопки категорий -->
    <div class="d-flex flex-wrap justify-content-center gap-2 mb-5">
        <a href="{{ route('menu.index') }}" 
           class="btn btn-outline-danger rounded-pill px-4">
            <i class="bi bi-arrow-left"></i> Всё меню
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('menu.category', $cat->slug) }}"
               class="btn {{ $cat->id === $category->id ? 'btn-danger' : 'btn-outline-danger' }} rounded-pill px-4">
                {{ $cat->name }}
                <span class="badge bg-light text-dark ms-1">{{ $cat->dishes->count() }}</span>
            </a>
        @endforeach
    </div>

    <!-- Заголовок результатов поиска -->
    @if($search)
        <div class="alert alert-info text-center mb-4">
            <h5 class="mb-0">
                Найдено блюд: {{ $dishes->total() }} по запросу "{{ $search }}"
                @if($dishes->count() < $dishes->total())
                    (показано {{ $dishes->count() }} из {{ $dishes->total() }})
                @endif
            </h5>
            <a href="{{ route('menu.category', $category->slug) }}" class="text-muted small">
                Показать все блюда категории
            </a>
        </div>
    @endif

    <!-- Сообщение если нет блюд -->
            @if($dishes->isEmpty())
            <div class="alert alert-warning text-center py-5">
                <h4>
                    @if($search)
                        По запросу "{{ $search }}" ничего не найдено
                    @else
                        В этой категории пока нет блюд
                    @endif
                </h4>
                <p>
                    @if($search)
                        Попробуйте изменить поисковый запрос
                        <br>
                        <a href="{{ route('menu.category', $category->slug) }}" class="btn btn-sm btn-outline-danger mt-2">
                            Показать все блюда категории
                        </a>
                    @else
                        Но мы уже работаем над новыми рецептами!
                    @endif
                </p>
            </div>
        @else
        <!-- Сетка блюд -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            @foreach($dishes as $dish)
                <div class="col">
                    <div class="card h-100 shadow-sm hover-shadow transition">
                        @if($dish->url_image)
                            <img src="/storage/{{ $dish->url_image }}" 
                                 class="card-img-top" 
                                 style="height: 200px; object-fit: cover;" 
                                 alt="{{ $dish->name }}">
                        @else
                            <div class="bg-light border-bottom d-flex align-items-center justify-content-center" 
                                 style="height: 200px;">
                                <i class="bi bi-image fs-1 text-muted"></i>
                            </div>
                        @endif

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fs-6 fw-bold">
                                {{ $dish->name }}
                                @if($dish->is_spicy)<i class="bi bi-fire text-danger ms-1"></i>@endif
                                @if($dish->is_vegetarian)<i class="bi bi-leaf text-success ms-1"></i>@endif
                            </h5>

                            @if($dish->description)
                                <p class="card-text text-muted small flex-grow-1">
                                    {{ Str::limit($dish->description, 70) }}
                                </p>
                            @endif

                            <div class="mt-auto d-flex justify-content-between align-items-end">
                                <span class="h5 text-danger mb-0">{{ number_format($dish->price, 0, '', ' ') }} ₽</span>
                                
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
            @endforeach
        </div>
    

        <!-- Наша кастомная надпись о пагинации -->
        @if($dishes->total() > 0)
            <div class="text-center text-muted small mb-3">
                Показано от
                <span class="fw-bold">{{ $dishes->firstItem() }}</span>
                до 
                <span class="fw-bold">{{ $dishes->lastItem() }}</span>
                из 
                <span class="fw-bold">{{ $dishes->total() }}</span>
                @if($dishes->total() == 1)
                    результата
                @elseif($dishes->total() >= 2 && $dishes->total() <= 4)
                    результата
                @else
                    результатов
                @endif
            </div>
        @endif

        <!-- Сама пагинация -->
        @if($dishes->hasPages())
            <div class="mt-3 text-center">
                {{ $dishes->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        @endif
    @endif
</div>
@endsection