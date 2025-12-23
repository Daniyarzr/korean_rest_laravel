@extends('layouts.app')

@section('title', 'Личный кабинет')
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


<div class="container py-5 content-h100">
    <h1 class="text-center mb-5 display-5 fw-bold">Личный кабинет</h1>
    
    <div class="row">
       
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                   
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
            @if(Auth::user()->role == 'admin' or Auth::user()->role == 'manager')
            <div class="btn-admin-panel">
                <a href="{{route('admin.dashboard')}}">Войти в Админ панель</a>
            </div>
            @endif
        </div>
        
        
        <div class="col-md-8">
           
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h4 class="card-title mb-3">Добро пожаловать, {{ Auth::user()->name }}!</h4>
                    <p class="card-text text-muted">Здесь вы можете управлять своей учетной записью, просматривать историю заказов и настройки доставки.</p>
                    
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                            <i class="bi bi-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                </div>
            </div>

            
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card border-0 bg-light">
                        <div class="card-body text-center">
                            <i class="bi bi-bag-check fs-1 text-danger mb-3"></i>
                            <h5>Всего заказов</h5>
                            <h2 class="text-danger">
                                {{$orders->count()}}
                            </h2>
                            @if($orders->count() > 0) 
                            <p class="text-muted small">Ваши заказы</p>
                            @else
                            <p class="text-muted small">У вас пока нет заказов</p>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card border-0 bg-light">
                        <div class="card-body text-center">
                            <i class="bi bi-clock-history fs-1 text-danger mb-3"></i>
                            <h5>Активные заказы</h5>
                            <h2 class="text-danger">0</h2>
                            <p class="text-muted small">в обработке</p>
                        </div>
                    </div>
                </div>
            </div>

          
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i> Контактная информация</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-3">
                                <strong><i class="bi bi-person me-2"></i> Имя:</strong><br>
                                <span class="ms-4">{{ Auth::user()->name }}</span>
                            </p>
                            <p class="mb-3">
                                <strong><i class="bi bi-envelope me-2"></i> Email:</strong><br>
                                <span class="ms-4">{{ Auth::user()->email }}</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-3">
                                <strong><i class="bi bi-telephone me-2"></i> Телефон:</strong><br>
                                <span class="ms-4">
                                    @if(Auth::user()->phone)
                                        {{ Auth::user()->phone }}
                                    @else
                                        <span class="text-muted">не указан</span>
                                    @endif
                                </span>
                            </p>
                            <p class="mb-3">
                                <strong><i class="bi bi-calendar me-2"></i> Дата регистрации:</strong><br>
                                <span class="ms-4">{{ Auth::user()->created_at->format('d.m.Y') }}</span>
                            </p>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('profile.edit') }}" class="btn btn-secondary">
                            <i class="bi bi-pencil me-2"></i> Редактировать профиль
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection