@extends('layouts.app')

@section('title', 'Главная')

@section('content')
<!-- Hero -->
<div class="hero text-center" style="max-height:870px;">
    <div class="container">
        <h1 class="display-3 fw-bold mb-4">Добро пожаловать в Кимчи House</h1>
        <p class="lead mb-5">Настоящий вкус Кореи — кимчи, пибимпаб, острые супы и многое другое</p>
        <a href="#reservation" class="btn btn-danger btn-lg px-5">Забронировать столик</a>
    </div>
</div>

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
                                <span class="h5 mb-0 text-danger">{{ $dish->price }} ₽</span>
                                <div>
                                    @if($dish->is_spicy)<i class="bi bi-fire spicy me-2" title="Остро"></i>@endif
                                    @if($dish->is_vegaterian)<i class="bi bi-leaf veg" title="Вегетарианское"></i>@endif
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