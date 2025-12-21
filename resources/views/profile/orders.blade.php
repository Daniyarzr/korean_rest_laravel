{{-- resources/views/profile/orders.blade.php --}}
@extends('layouts.app')

@section('title', 'Мои заказы')

<style>
    
    .content-h100{
        height:100vh;
    }
      .btn-logout{
        border:0;
        background-color: #ffffff00;
        width: 100%;
        color:red;
    }
    .btn-logout:hover{
        color: rgb(121, 121, 121);
    }
</style>
@section('content')
<div class="container py-5 ">
    <div class="row">
        <!-- Боковое меню (30% ширины) -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <!-- Аватарка (иконка) -->
                    <div class="mb-4">
                        <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center" 
                            style="width: 100px; height: 100px;">
                            @php
                                $firstLetter = mb_strtoupper(mb_substr(Auth::user()->name, 0, 1));
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
                      <form  id="logout-form" action="{{ route('logout') }}" method="POST" >
                           @csrf
                           <div class="list-group-item list-group-item-action cnt-logout border-0" >
                            
                            <button class="btn-logout" type="submit">
                                <i   class="bi bi-box-arrow-right me-2"></i> 
                                Выйти</button>
                           </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Основной контент (70% ширины) -->
        <div class="col-md-8">
            <!-- Заголовок -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0"><i class="bi bi-bag me-2"></i> История заказов</h4>
                        <div class="text-muted small">
                            Всего заказов: <span class="badge bg-danger">{{ $orders->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Список заказов -->
            @if($orders->isEmpty())
                <div class="card shadow-sm text-center py-5">
                    <div class="card-body">
                        <i class="bi bi-bag-x display-1 text-muted mb-4"></i>
                        <h4 class="alert-heading mb-3">Заказов пока нет</h4>
                        <p class="mb-4">Сделайте свой первый заказ из нашего меню</p>
                        <a href="{{ route('menu.index') }}" class="btn btn-danger rounded-pill px-4">
                            <i class="bi bi-arrow-left me-2"></i> Перейти в меню
                        </a>
                    </div>
                </div>
            @else
                @foreach($orders as $order)
                <div class="card shadow-sm border rounded-3 mb-4 
                @if($order->status == 'cancelled')
                border-danger-subtle 
                text-body-tertiary
                text-opacity-25
                @endif">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="card-title mb-1">
                                    Заказ #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                                </h5>
                                <div class="text-muted small">
                                    <i class="bi bi-calendar me-1"></i> {{ $order->created_at->format('d.m.Y H:i') }}
                                </div>
                            </div>
                            <div class="text-end">
                                <span class="badge 
                                    @if($order->status == 'new') bg-warning text-dark
                                    @elseif($order->status == 'processing') bg-info
                                    @elseif($order->status == 'completed') bg-success
                                    @elseif($order->status == 'cancelled') bg-danger
                                    @else bg-secondary @endif 
                                    px-3 py-2 rounded-pill">
                                    @if($order->status == 'new') Новый
                                    @elseif($order->status == 'processing') В процессе
                                    @elseif($order->status == 'completed') Завершен
                                    @elseif($order->status == 'cancelled') Отменен
                                    @else {{ $order->status }} @endif
                                </span>
                                <h4 class="text-danger mt-2">{{ number_format($order->total, 0, '', ' ') }} ₽</h4>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <small class="text-muted"><i class="bi bi-person me-1"></i> Имя</small>
                                    <div>{{ $order->customer_name }}</div>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted"><i class="bi bi-telephone me-1"></i> Телефон</small>
                                    <div>{{ $order->phone }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <small class="text-muted"><i class="bi bi-geo-alt me-1"></i> Адрес доставки</small>
                                    <div>{{ $order->delivery_address }}</div>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted"><i class="bi bi-cash-coin me-1"></i> Способ оплаты</small>
                                    <div>
                                        @if($order->payment_method == 'cash')
                                            Наличными курьеру
                                        @else
                                            Картой онлайн
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        @if($order->notes)
                        <div class="alert alert-light border rounded-3 mb-3">
                            <small class="text-muted"><i class="bi bi-chat-left-text me-1"></i> Комментарий к заказу</small>
                            <div class="mt-1">{{ $order->notes }}</div>
                        </div>
                        @endif
                        
                        <!-- Товары в заказе -->
                        <div class="border-top pt-3">
                            <h6 class="mb-3">Состав заказа:</h6>
                            <div class="table-responsive">
                                <table class="table table-borderless table-sm">
                                    <tbody>
                                        @foreach($order->items as $item)
                                        <tr class="border-bottom">
                                            <td class="ps-0 py-2">
                                                <div class="d-flex align-items-center">
                                                    @if($item->dish->url_image)
                                                        <img src="{{ asset('storage/' . $item->dish->url_image) }}" 
                                                             class="rounded-3 me-3" 
                                                             style="width: 40px; height: 40px; object-fit: cover;">
                                                    @endif
                                                    <div>
                                                        <div class="fw-bold">{{ $item->dish->name }}</div>
                                                        <div class="text-muted small">{{ number_format($item->price, 0, '', ' ') }} ₽ × {{ $item->quantity }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-end fw-bold">
                                                {{ number_format($item->price * $item->quantity, 0, '', ' ') }} ₽
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Кнопки действий -->
                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <a href="{{ route('profile.order.show', $order) }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                <i class="bi bi-eye me-1"></i> Подробнее
                            </a>
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
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection