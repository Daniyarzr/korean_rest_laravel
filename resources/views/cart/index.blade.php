{{-- resources/views/cart/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Корзина')

<style>
    .cart-item:hover {
        background-color: #f8f9fa;
    }
    .quantity-input {
        width: 70px;
    }
</style>

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-5 display-5 fw-bold">🛒 Ваша корзина</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show text-center rounded-pill" role="alert" style="position:fixed; top:75px; right: 40; z-index:100; max-width: 500px; margin: 0 auto 30px;">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($cart->items->isEmpty())
        <div class="alert alert-info text-center py-5 rounded-3" style="max-width: 600px; margin: 0 auto;">
            <div class="py-3">
                <i class="bi bi-cart-x display-1 text-muted mb-4"></i>
                <h4 class="alert-heading mb-3">Корзина пуста</h4>
                <p class="mb-4">Добавьте блюда из меню, чтобы сделать заказ</p>
                <a href="{{ route('menu.index') }}" class="btn btn-danger rounded-pill px-4">
                    <i class="bi bi-arrow-left me-2"></i> Перейти в меню
                </a>
            </div>
        </div>
    @else
        <div class="row">
            <!-- Список товаров -->
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-3 mb-4">
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <thead class="border-bottom">
                                    <tr class="text-muted">
                                        <th class="ps-0">Блюдо</th>
                                        <th class="text-center">Количество</th>
                                        <th class="text-end pe-0">Сумма</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cart->items as $item)
                                    <tr class="cart-item align-middle border-bottom">
                                        <td class="ps-0 py-3">
                                            <div class="d-flex align-items-center">
                                                @if($item->dish->url_image)
                                                    <img src="{{ asset('storage/' . $item->dish->url_image) }}" 
                                                         class="rounded-3 me-3" 
                                                         style="width: 70px; height: 70px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light rounded-3 me-3 d-flex align-items-center justify-content-center"
                                                         style="width: 70px; height: 70px;">
                                                        <i class="bi bi-image text-muted"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <h6 class="mb-1">{{ $item->dish->name }}</h6>
                                                    <div class="text-muted small">
                                                        @if($item->dish->is_spicy)
                                                            <i class="bi bi-fire text-danger me-1"></i> Острое
                                                        @endif
                                                        @if($item->dish->is_vegetarian)
                                                            <i class="bi bi-leaf text-success ms-2 me-1"></i> Вегетарианское
                                                        @endif
                                                    </div>
                                                    <div class="text-danger fw-bold mt-1">
                                                        {{ number_format($item->price, 0, '', ' ') }} ₽
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-inline-block">
                                                @csrf
                                                @method('PUT')
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <input type="number" 
                                                        name="quantity" 
                                                        value="{{ $item->quantity }}" 
                                                        min="1" 
                                                        max="10" 
                                                        class="form-control form-control-sm text-center quantity-input"
                                                        style="width: 60px;">
                                                    <button type="submit" class="btn btn-outline-danger btn-sm ms-2 rounded-circle" 
                                                            style="width: 32px; height: 32px; padding: 0;">
                                                        <i class="bi bi-check"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </td>
                                        <td class="text-end fw-bold pe-0">
                                            {{ number_format($item->subtotal, 0, '', ' ') }} ₽
                                        </td>
                                        <td class="text-end">
                                            <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" 
                                                        style="width: 32px; height: 32px; padding: 0;">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Кнопки действий -->
                <div class="d-flex gap-2 align-items-center mt-4">
                    <a href="{{ route('menu.index') }}" class="btn btn-outline-danger rounded-pill px-4 py-2">
                        <i class="bi bi-arrow-left me-2"></i> Продолжить покупки
                    </a>
                    <form action="{{ route('cart.clear') }}" method="POST" class="d-inline m-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-warning rounded-pill px-4 py-2">
                            <i class="bi bi-trash me-2"></i> Очистить корзину
                        </button>
                    </form>
                </div>
            </div>

            <!-- Итого и оформление -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 rounded-3 sticky-top" style="top: 20px;">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-4 text-center">Ваш заказ</h5>
                        
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Товары ({{ $cart->items_count }} шт.)</span>
                                <span class="fw-bold">{{ number_format($cart->total, 0, '', ' ') }} ₽</span>
                            </div>
                            
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Доставка</span>
                                <span class="text-success fw-bold">Бесплатно</span>
                            </div>
                        </div>
                        
                        <div class="border-top pt-3 mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">К оплате</h5>
                                <h4 class="text-danger mb-0">{{ number_format($cart->total, 0, '', ' ') }} ₽</h4>
                            </div>
                        </div>

                        @auth
                            <button class="btn btn-danger btn-lg w-100 mb-3 rounded-pill" id="checkoutBtn">
                                <i class="bi bi-bag-check me-2"></i> Оформить заказ
                            </button>
                        @else
                            <div class="alert alert-warning border-0 rounded-3 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-info-circle fs-4 me-3"></i>
                                    <div>
                                        <p class="mb-1"><strong>Войдите для оформления заказа</strong></p>
                                        <p class="small mb-0">Сохраните корзину и получите доступ к истории заказов</p>
                                    </div>
                                </div>
                                <div class="d-grid gap-2 mt-3">
                                    <a href="{{ route('login') }}" class="btn btn-danger rounded-pill">Войти</a>
                                    <a href="{{ route('register') }}" class="btn btn-outline-danger rounded-pill">Зарегистрироваться</a>
                                </div>
                            </div>
                        @endauth
                        
                        <div class="text-center text-muted small mt-4 pt-3 border-top">
                            <p class="mb-1"><i class="bi bi-shield-check text-success me-1"></i> Безопасная оплата</p>
                            <p class="mb-0"><i class="bi bi-clock text-primary me-1"></i> Доставка 30-60 минут</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
document.getElementById('checkoutBtn')?.addEventListener('click', function() {
    // В будущем здесь будет логика оформления заказа
    alert('Функция оформления заказа будет добавлена позже!');
});
</script>
@endsection