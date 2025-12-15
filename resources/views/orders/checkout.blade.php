{{-- resources/views/orders/checkout.blade.php --}}
@extends('layouts.app')

@section('title', 'Оформление заказа')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-5 display-5 fw-bold">📝 Оформление заказа</h1>

    <div class="row">
        <!-- Левая колонка - Товары -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-3 mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0"><i class="bi bi-basket me-2"></i> Ваш заказ</h5>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-borderless mb-0">
                            <thead class="border-bottom">
                                <tr class="text-muted">
                                    <th class="ps-0">Блюдо</th>
                                    <th class="text-center">Количество</th>
                                    <th class="text-end pe-0">Сумма</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                <tr class="align-middle border-bottom">
                                    <td class="ps-0 py-3">
                                        <div class="d-flex align-items-center">
                                            @if($item->dish->url_image)
                                                <img src="{{ asset('storage/' . $item->dish->url_image) }}" 
                                                     class="rounded-3 me-3" 
                                                     style="width: 60px; height: 60px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded-3 me-3 d-flex align-items-center justify-content-center"
                                                     style="width: 60px; height: 60px;">
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
                                    <td class="text-center align-middle">
                                        <div class="badge bg-light text-dark rounded-pill py-2 px-3">
                                            x{{ $item->quantity }}
                                        </div>
                                    </td>
                                    <td class="text-end fw-bold align-middle">
                                        {{ number_format($item->subtotal, 0, '', ' ') }} ₽
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Итого -->
                    <div class="border-top pt-4 mt-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Итого {{ $items_count }} товар(ов)</h6>
                                <small class="text-muted">Бесплатная доставка</small>
                            </div>
                            <h4 class="text-danger mb-0">{{ number_format($total, 0, '', ' ') }} ₽</h4>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Вернуться в корзину -->
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('cart.index') }}" class="btn btn-outline-danger rounded-pill px-4 py-2">
                    <i class="bi bi-arrow-left me-2"></i> Вернуться в корзину
                </a>
                <div class="text-muted small">
                    <i class="bi bi-clock text-primary me-1"></i> Доставка 30-60 минут
                </div>
            </div>
        </div>

        <!-- Правая колонка - Форма -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-3 sticky-top" style="top: 20px;">
                <div class="card-body p-4">
                    <h5 class="card-title mb-4 text-center"><i class="bi bi-truck me-2"></i> Данные для доставки</h5>
                    
                    <form action="{{ route('orders.store') }}" method="POST" id="checkoutForm">
                        @csrf
                        
                        <!-- Имя -->
                        <div class="mb-4">
                            <label for="customer_name" class="form-label fw-bold">Имя *</label>
                            <input type="text" 
                                   class="form-control rounded-3 py-2" 
                                   id="customer_name" 
                                   name="customer_name"
                                   value="{{ auth()->user()->name ?? '' }}"
                                   required>
                            <div class="form-text">Как к вам обращаться</div>
                        </div>
                        
                        <!-- Телефон -->
                        <div class="mb-4">
                            <label for="customer_phone" class="form-label fw-bold">Телефон *</label>
                            <input type="tel" 
                                   class="form-control rounded-3 py-2" 
                                   id="customer_phone" 
                                   name="phone"
                                   value="{{ auth()->user()->phone ?? '' }}"
                                   placeholder="+7 (999) 999-99-99"
                                   required>
                            <div class="form-text">Для связи по поводу заказа</div>
                        </div>
                        
                        <!-- Адрес -->
                        <div class="mb-4">
                            <label for="delivery_address" class="form-label fw-bold">Адрес доставки *</label>
                            <textarea class="form-control rounded-3" 
                                      id="delivery_address" 
                                      name="delivery_address" 
                                      rows="3"
                                      placeholder="Улица, дом, квартира, этаж, код домофона"
                                      required></textarea>
                            <div class="form-text">Укажите точный адрес доставки</div>
                        </div>
                        
                        <!-- Способ оплаты -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Способ оплаты *</label>
                            <div class="d-grid gap-2">
                                <div class="form-check border rounded-3 p-3">
                                    <input class="form-check-input" 
                                           type="radio" 
                                           name="payment_method" 
                                           id="cash" 
                                           value="cash" 
                                           checked>
                                    <label class="form-check-label d-flex align-items-center" for="cash">
                                        <i class="bi bi-cash-coin fs-4 text-success me-3"></i>
                                        <div>
                                            <strong>Наличными курьеру</strong>
                                            <div class="text-muted small">Оплата при получении</div>
                                        </div>
                                    </label>
                                </div>
                                
                                <div class="form-check border rounded-3 p-3">
                                    <input class="form-check-input" 
                                           type="radio" 
                                           name="payment_method" 
                                           id="card" 
                                           value="card">
                                    <label class="form-check-label d-flex align-items-center" for="card">
                                        <i class="bi bi-credit-card fs-4 text-primary me-3"></i>
                                        <div>
                                            <strong>Картой онлайн</strong>
                                            <div class="text-muted small">Оплата на сайте</div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Комментарий -->
                        <div class="mb-4">
                            <label for="notes" class="form-label fw-bold">Комментарий к заказу</label>
                            <textarea class="form-control rounded-3" 
                                      id="notes" 
                                      name="notes" 
                                      rows="2"
                                      placeholder="Например: позвонить за 15 минут, оставить у двери, не звонить в домофон"></textarea>
                        </div>
                        
                        <!-- Соглашение -->
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="agreement" required checked>
                            <label class="form-check-label small" for="agreement">
                                Я согласен с <a href="#" class="text-decoration-none">правилами обработки персональных данных</a> и <a href="#" class="text-decoration-none">условиями доставки</a>
                            </label>
                        </div>
                        
                        <!-- Кнопка оформления -->
                        <button type="submit" class="btn btn-danger btn-lg w-100 rounded-pill py-3" id="submitBtn">
                            <i class="bi bi-bag-check me-2"></i> Подтвердить заказ
                        </button>
                        
                        <!-- Итоговая сумма -->
                        <div class="text-center mt-3 pt-3 border-top">
                            <div class="text-muted small mb-1">К оплате</div>
                            <h3 class="text-danger">{{ number_format($total, 0, '', ' ') }} ₽</h3>
                        </div>
                    </form>
                    
                    <!-- Гарантии -->
                    <div class="text-center text-muted small mt-4 pt-3 border-top">
                        <p class="mb-2"><i class="bi bi-shield-check text-success me-1"></i> Безопасная оплата</p>
                        <p class="mb-2"><i class="bi bi-lock text-primary me-1"></i> Ваши данные защищены</p>
                        <p class="mb-0"><i class="bi bi-clock-history text-warning me-1"></i> Поддержка 24/7</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i> Оформляем заказ...';
});

// Маска для телефона
document.getElementById('phone').addEventListener('input', function(e) {
    let x = e.target.value.replace(/\D/g, '').match(/(\d{0,1})(\d{0,3})(\d{0,3})(\d{0,2})(\d{0,2})/);
    e.target.value = !x[2] ? x[1] : '+7 (' + x[2] + ') ' + x[3] + (x[4] ? '-' + x[4] : '') + (x[5] ? '-' + x[5] : '');
});
</script>
@endpush
@endsection