{{-- resources/views/orders/success.blade.php --}}
@extends('layouts.app')

@section('title', 'Заказ оформлен')

@section('content')
<div class="container py-5">
    <div class="text-center py-5">
        <!-- Анимация успеха -->
        <div class="mb-4">
            <div class="d-inline-block p-4 rounded-circle bg-success bg-opacity-10">
                <i class="bi bi-check-circle-fill text-success display-1"></i>
            </div>
        </div>
        
        <h1 class="display-5 fw-bold mb-3">🎉 Заказ оформлен!</h1>
        <p class="lead text-muted mb-4">Спасибо за ваш заказ. Мы уже начали его готовить.</p>
        
        <!-- Карточка с информацией -->
        <div class="card shadow-sm border-0 rounded-3 mx-auto" style="max-width: 600px;">
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <h6 class="text-muted mb-2"><i class="bi bi-hash me-2"></i> Номер заказа</h6>
                        <h4 class="fw-bold text-primary">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h4>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6 class="text-muted mb-2"><i class="bi bi-clock me-2"></i> Статус</h6>
                        <span class="badge bg-warning text-dark fs-6 px-3 py-2 rounded-pill">
                            <i class="bi bi-hourglass-split me-1"></i> Новый
                        </span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6 class="text-muted mb-2"><i class="bi bi-cash-coin me-2"></i> Сумма</h6>
                        <h4 class="fw-bold text-danger">{{ $order->total_formatted }}</h4>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6 class="text-muted mb-2"><i class="bi bi-geo-alt me-2"></i> Доставка</h6>
                        <p class="mb-0">{{ $order->delivery_address }}</p>
                    </div>
                </div>
                
                <div class="border-top pt-4 mt-3">
                    <h6 class="text-muted mb-3"><i class="bi bi-info-circle me-2"></i> Что дальше?</h6>
                    <div class="row">
                        <div class="col-6 col-md-3 mb-3 text-center">
                            <div class="p-3 rounded-3 bg-light">
                                <i class="bi bi-telephone fs-4 text-primary mb-2"></i>
                                <div class="small">Подтверждение заказа</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-3 text-center">
                            <div class="p-3 rounded-3 bg-light">
                                <i class="bi bi-cup-hot fs-4 text-success mb-2"></i>
                                <div class="small">Приготовление</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-3 text-center">
                            <div class="p-3 rounded-3 bg-light">
                                <i class="bi bi-bicycle fs-4 text-warning mb-2"></i>
                                <div class="small">Доставка</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-3 text-center">
                            <div class="p-3 rounded-3 bg-light">
                                <i class="bi bi-house-check fs-4 text-danger mb-2"></i>
                                <div class="small">Получение</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Кнопки действий -->
        <div class="d-flex flex-column flex-md-row gap-3 justify-content-center mt-5">
            <!-- Вместо orders.show -> profile.order.show -->
            <a href="{{ route('profile.order.show', $order) }}" class="btn btn-outline-primary rounded-pill px-4 py-2">
                <i class="bi bi-eye me-2"></i> Посмотреть заказ
            </a>
            <!-- Вместо orders.index -> profile.orders -->
            <a href="{{ route('profile.orders') }}" class="btn btn-outline-success rounded-pill px-4 py-2">
                <i class="bi bi-list-check me-2"></i> Мои заказы
            </a>
            <a href="{{ route('menu.index') }}" class="btn btn-danger rounded-pill px-4 py-2">
                <i class="bi bi-arrow-right me-2"></i> Вернуться в меню
            </a>
        </div>
        
        <!-- Контакты -->
        <div class="text-center text-muted small mt-5 pt-4 border-top">
            <p class="mb-2">Остались вопросы? Звоните: <strong>8 (800) 123-45-67</strong></p>
            <p class="mb-0">Или пишите в WhatsApp: <strong>+7 (999) 123-45-67</strong></p>
        </div>
    </div>
</div>
@endsection