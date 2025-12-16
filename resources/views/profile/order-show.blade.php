{{-- resources/views/profile/order-show.blade.php --}}
@extends('layouts.app')

@section('title', 'Заказ #' . str_pad($order->id, 6, '0', STR_PAD_LEFT))

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Боковое меню (30% ширины) -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <!-- Аватарка -->
                    <div class="mb-4">
                        <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center" 
                            style="width: 100px; height: 100px;">
                            @php
                                $firstLetter = strtoupper(substr(Auth::user()->name, 0, 1));
                            @endphp
                            <span class="text-white fw-bold" style="font-size: 2.5rem;">{{ $firstLetter }}</span>
                        </div>
                    </div>
                    
                    <h5 class="mb-1">{{ Auth::user()->name }}</h5>
                    <p class="text-muted small">{{ Auth::user()->email }}</p>
                    
                    <hr class="my-3">
                    
                    <!-- Меню навигации -->
                    <div class="list-group list-group-flush">
                        <a href="{{ route('profile.index') }}" 
                           class="list-group-item list-group-item-action {{ request()->routeIs('profile.index') ? 'active' : '' }}">
                            <i class="bi bi-person me-2"></i> Мой профиль
                        </a>
                        <a href="{{ route('profile.orders') }}" 
                           class="list-group-item list-group-item-action {{ request()->routeIs('profile.orders') ? 'active' : '' }}">
                            <i class="bi bi-bag me-2"></i> Мои заказы
                        </a>
                        <a href="{{ route('profile.reservations') }}"
                        class="list-group-item {{ request()->routeIs('profile.reservations') ? 'active' : '' }}">
                            <i class="bi bi-calendar-check me-2"></i> Мои бронирования
                        </a>
                        <a href="{{ route('profile.addresses') }}" 
                           class="list-group-item list-group-item-action {{ request()->routeIs('profile.addresses') ? 'active' : '' }}">
                            <i class="bi bi-geo-alt me-2"></i> Адреса доставки
                        </a>
                        <a href="{{ route('profile.edit') }}" 
                           class="list-group-item list-group-item-action {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                            <i class="bi bi-pencil me-2"></i> Редактировать профиль
                        </a>
                        <a href="{{ route('logout') }}" 
                           class="list-group-item list-group-item-action text-danger"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right me-2"></i> Выйти
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Основной контент (70% ширины) -->
        <div class="col-md-8">
            <!-- Хлебные крошки -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('profile.orders') }}">Мои заказы</a></li>
                    <li class="breadcrumb-item active">Заказ #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</li>
                </ol>
            </nav>
            
            <!-- Заголовок -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="display-6 fw-bold">Заказ #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h1>
                <span class="badge 
                    @if($order->status == 'new') bg-warning text-dark
                    @elseif($order->status == 'processing') bg-info
                    @elseif($order->status == 'completed') bg-success
                    @elseif($order->status == 'cancelled') bg-danger
                    @else bg-secondary @endif 
                    px-4 py-2 fs-6 rounded-pill">
                    @if($order->status == 'new') Новый
                    @elseif($order->status == 'processing') В процессе
                    @elseif($order->status == 'completed') Завершен
                    @elseif($order->status == 'cancelled') Отменен
                    @else {{ $order->status }} @endif
                </span>
            </div>
            
            <div class="row">
                <!-- Левая колонка - Информация -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm border-0 rounded-3 h-100">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-4"><i class="bi bi-info-circle me-2"></i> Информация о заказе</h5>
                            
                            <div class="mb-3">
                                <small class="text-muted"><i class="bi bi-calendar me-1"></i> Дата и время</small>
                                <div class="fw-bold">{{ $order->created_at->format('d.m.Y H:i') }}</div>
                            </div>
                            
                            <div class="mb-3">
                                <small class="text-muted"><i class="bi bi-person me-1"></i> Имя заказчика</small>
                                <div class="fw-bold">{{ $order->customer_name }}</div>
                            </div>
                            
                            <div class="mb-3">
                                <small class="text-muted"><i class="bi bi-telephone me-1"></i> Телефон</small>
                                <div class="fw-bold">{{ $order->phone }}</div>
                            </div>
                            
                            <div class="mb-3">
                                <small class="text-muted"><i class="bi bi-geo-alt me-1"></i> Адрес доставки</small>
                                <div class="fw-bold">{{ $order->delivery_address }}</div>
                            </div>
                            
                            <div class="mb-3">
                                <small class="text-muted"><i class="bi bi-cash-coin me-1"></i> Способ оплаты</small>
                                <div class="fw-bold">
                                    @if($order->payment_method == 'cash')
                                        <i class="bi bi-cash text-success me-1"></i> Наличными курьеру
                                    @else
                                        <i class="bi bi-credit-card text-primary me-1"></i> Картой онлайн
                                    @endif
                                </div>
                            </div>
                            
                            @if($order->notes)
                            <div class="mt-4 pt-3 border-top">
                                <small class="text-muted"><i class="bi bi-chat-left-text me-1"></i> Комментарий</small>
                                <div class="mt-2 p-3 bg-light rounded-3">
                                    {{ $order->notes }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Правая колонка - Товары и сумма -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm border-0 rounded-3 h-100">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-4"><i class="bi bi-basket me-2"></i> Состав заказа</h5>
                            
                            <div class="table-responsive mb-4">
                                <table class="table table-borderless">
                                    <tbody>
                                        @foreach($order->items as $item)
                                        <tr class="border-bottom">
                                            <td class="ps-0 py-3">
                                                <div class="d-flex align-items-center">
                                                    @if($item->dish->url_image)
                                                        <img src="{{ asset('storage/' . $item->dish->url_image) }}" 
                                                             class="rounded-3 me-3" 
                                                             style="width: 50px; height: 50px; object-fit: cover;">
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
                                                            {{ number_format($item->price, 0, '', ' ') }} ₽ × {{ $item->quantity }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-end fw-bold align-middle">
                                                {{ number_format($item->price * $item->quantity, 0, '', ' ') }} ₽
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Итого -->
                            <div class="border-top pt-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">Товары ({{ $order->items->sum('quantity') }} шт.)</span>
                                    <span class="fw-bold">{{ number_format($order->total, 0, '', ' ') }} ₽</span>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-muted">Доставка</span>
                                    <span class="text-success fw-bold">Бесплатно</span>
                                </div>
                                
                                <div class="border-top pt-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">К оплате</h5>
                                        <h3 class="text-danger mb-0">{{ number_format($order->total, 0, '', ' ') }} ₽</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Кнопки действий -->
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('profile.orders') }}" class="btn btn-outline-danger rounded-pill px-4">
                    <i class="bi bi-arrow-left me-2"></i> Назад к заказам
                </a>
                
                <div class="d-flex gap-2">
                    @if($order->status == 'new')
                 <form action="{{ route('orders.cancel', $order) }}" method="POST" class="d-inline">
                    @csrf
                    @method('POST')
                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3" 
                            onclick="return confirm('Вы уверены, что хотите отменить заказ?')">
                        <i class="bi bi-x-circle me-1"></i> Отменить
                    </button>
                </form>
                    @endif
                    
                    <a href="{{ route('menu.index') }}" class="btn btn-danger rounded-pill px-4">
                        <i class="bi bi-bag-plus me-2"></i> Сделать новый заказ
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection