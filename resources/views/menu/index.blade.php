@extends('layouts.app')

@section('title', 'Меню')
<style>
    .hover-shadow {
        transition: all 0.3s ease;
    }
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.15) !important;
    }
    .form-search-menu{
        width: 40%;
    }
    /* Стили для пагинации */
    .pagination .page-link {
        color: #dc3545;
        border-color: #dc3545;
    }
    .pagination .page-item.active .page-link {
        background-color: #dc3545;
        border-color: #dc3545;
    }
    .pagination .small.text-muted {
        display:none; !important; /* Скрываем текст */
}
</style>
@section('content')
<div class="container py-5">
    <h1 class="text-center mb-5 display-5 fw-bold">Полное меню</h1>

    <!-- Форма поиска -->
    <div class="form-search-menu text-center mb-5 ms-auto me-auto">
        <form action="{{ route('menu.index') }}" method="GET" class="d-inline-block w-100" style="max-width: 500px;">
            <div class="position-relative">
                <input type="text" 
                    class="form-control rounded-pill py-3 px-4 border-danger" 
                    name="search" 
                    placeholder="Поиск блюд..."
                    value="{{ $search }}">
                <button type="submit" class="btn btn-danger rounded-pill position-absolute end-0 top-0 bottom-0 m-1 px-4">
                    Найти
                </button>
            </div>
        </form>
    </div>
    
    <!-- Кнопки категорий -->
    <div class="d-flex flex-wrap justify-content-center gap-2 mb-5">
        <a href="{{ route('menu.index') }}" 
           class="btn {{ !$search ? 'btn-danger' : 'btn-outline-danger' }} rounded-pill px-4">
            <i class="bi bi-grid-3x3-gap"></i> Всё меню
        </a>

        @foreach($categories as $cat)
            <a href="{{ route('menu.category', $cat->slug) }}"
               class="btn btn-outline-danger rounded-pill px-4">
                {{ $cat->name }}
                <span class="badge bg-light text-dark ms-1">{{ $cat->dishes->count() }}</span>
            </a>
        @endforeach
    </div>

    <!-- Заголовок результатов поиска -->
    @if($search)
        <div class="alert alert-info text-center mb-4">
            <h5 class="mb-0">
                Найдено блюд: {{ $allDishes->total() }} по запросу "{{ $search }}"
                @if($allDishes->count() < $allDishes->total())
                    (показано {{ $allDishes->count() }} из {{ $allDishes->total() }})
                @endif
            </h5>
            
        </div>
    @endif

    <!-- Если блюд нет -->
    @if($allDishes->isEmpty())
        <div class="alert alert-warning text-center py-5">
            <h4>Блюд не найдено</h4>
            <p>Попробуйте изменить поисковый запрос или посмотрите все меню</p>
            <a href="{{ route('menu.index') }}" class="btn btn-sm btn-outline-danger mt-2">Показать все блюда</a>
        </div>
    @else
        <!-- Все блюда сеткой -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            @foreach($allDishes as $dish)
                <div class="col">
                    <div class="card h-100 shadow-sm hover-shadow">
                        @if($dish->url_image)
                            <img src="{{ asset('storage/' . $dish->url_image) }}" 
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

                            <small class="text-muted mb-2">
                                @if($dish->category)
                                    {{ $dish->category->name }}
                                @else
                                    <span class="text-warning">Без категории</span>
                                @endif
                            </small>

                            @if($dish->description)
                                <p class="card-text text-muted small flex-grow-1">
                                    {{ Str::limit($dish->description, 70) }}
                                </p>
                            @endif

                            <div class="mt-auto d-flex justify-content-between align-items-end">
                                <span class="h5 text-danger mb-0">{{ number_format($dish->price, 0, '', ' ') }} ₽</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

                <!-- Наша кастомная надпись о пагинации -->
        @if($allDishes->total() > 0)
            <div class="text-center text-muted small mb-3">
                Показано от
                <span class="fw-bold">{{ $allDishes->firstItem() }}</span>
                до 
                <span class="fw-bold">{{ $allDishes->lastItem() }}</span>
                из 
                <span class="fw-bold">{{ $allDishes->total() }}</span>
                @if($allDishes->total() == 1)
                    результата
                @elseif($allDishes->total() >= 2 && $allDishes->total() <= 4)
                    результатов
                @else
                    результатов
                @endif
            </div>
        @endif

        <!-- Сама пагинация -->
        @if($allDishes->hasPages())
            <div class="mt-3 text-center">
                {{ $allDishes->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        @endif
    @endif
</div>
@endsection