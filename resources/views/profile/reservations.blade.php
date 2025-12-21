@extends('layouts.app')

@section('title', 'Мои бронирования')
<style>
    .list-group-item.active {
        background-color: #dc3545;
        border-color: #dc3545;
    }
    .list-group-item:hover {
        background-color: #f8f9fa;
    }
    .card {
        border-radius: 10px;
        border: 1px solid rgba(0,0,0,.125);
    }
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
<div class="container py-5">
    <div class="row">
        <!-- Боковое меню -->
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

        <!-- Контент -->
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="bi bi-calendar-check me-2"></i> Мои бронирования</h4>
                    <div class="text-muted small">
                        Всего: <span class="badge bg-danger">{{ $reservations->total() }}</span>
                    </div>
                </div>
            </div>

            

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($reservations->count() === 0)
                <div class="card shadow-sm">
                    <div class="card-body text-center text-muted">
                        Бронирований пока нет.
                    </div>
                </div>
            @else
                @foreach($reservations as $r)
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <div class="text-muted small mb-1">Дата и время</div>
                                    <div class="fw-semibold h5">
                                        {{ \Illuminate\Support\Carbon::parse($r->date)->format('d.m.Y') }}
                                        {{ \Illuminate\Support\Carbon::parse($r->time)->format('H:i') }}
                                    </div>
                                </div>

                                <span class="badge 
                                    @if($r->status === 'new') bg-warning text-dark
                                    @elseif($r->status === 'confirmed') bg-success
                                    @elseif($r->status === 'cancelled') bg-secondary
                                    @else bg-info
                                    @endif
                                ">
                                    @if($r->status === 'new') Новая
                                    @elseif($r->status === 'confirmed') Подтверждена
                                    @elseif($r->status === 'cancelled') Отменена
                                    @else {{ $r->status }}
                                    @endif
                                </span>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="text-muted small">Гостей</div>
                                    <div class="fw-medium">{{ $r->guests }} чел.</div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="text-muted small">Телефон</div>
                                    <div class="fw-medium">{{ $r->phone }}</div>
                                </div>
                            </div>

                            @if($r->comment)
                                <div class="mb-3">
                                    <div class="text-muted small">Комментарий</div>
                                    <div>{{ $r->comment }}</div>
                                </div>
                            @endif

                            @if($r->status === 'new' || $r->status === 'confirmed')
                                <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                    <small class="text-muted">
                                        Создано: {{ $r->created_at->format('d.m.Y H:i') }}
                                    </small>
                                    
                                    <button type="button" 
                                            class="btn btn-outline-danger btn-sm" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#cancelModal{{ $r->id }}">
                                        <i class="bi bi-x-circle me-1"></i> Отменить
                                    </button>
                                </div>
                            @else
                                <div class="border-top pt-3">
                                    <small class="text-muted">
                                        Создано: {{ $r->created_at->format('d.m.Y H:i') }}
                                    </small>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Модальное окно подтверждения отмены -->
                    <div class="modal fade" id="cancelModal{{ $r->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Подтверждение отмены</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Вы уверены, что хотите отменить бронирование на 
                                    <strong>{{ \Illuminate\Support\Carbon::parse($r->date)->format('d.m.Y') }} {{ $r->time }}</strong> 
                                    для {{ $r->guests }} гостей?</p>
                                    
                                    @if($r->status === 'confirmed')
                                        <div class="alert alert-warning">
                                            <i class="bi bi-exclamation-triangle"></i> 
                                            Бронирование уже подтверждено. Отмена может быть невозможна.
                                        </div>
                                    @endif
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Нет</button>
                                    <form action="{{ route('reservations.cancel', $r->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-danger">
                                            Да, отменить
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="mt-3">
                    {{ $reservations->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection