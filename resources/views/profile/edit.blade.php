@extends('layouts.app')

@section('title', 'Редактирование профиля')

<style>
    .list-group-item.active {
        background-color: #dc3545;
        border-color: #dc3545;
    }
    .card {
        border-radius: 10px;
    }
    .form-label {
        font-weight: 500;
    }
    .content-h100{
        min-height:100vh;
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
    <h1 class="text-center mb-5 display-5 fw-bold">Редактирование профиля</h1>
    
    <div class="row">
        
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <!-- Аватарка с буквой -->
                    <div class="mb-4">
                        <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm" 
                             style="width: 100px; height: 100px;">
                            <span class="text-white fw-bold" style="font-size: 2.5rem;">
                                {{ strtoupper(mb_substr(Auth::user()->name, 0, 1)) }}
                            </span>
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
                <a href="{{route('admin.users.index')}}">Войти в Админ панель</a>
            </div>
            @endif
        </div>

        
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h4 class="mb-0"><i class="bi bi-pencil-square me-2"></i> Изменение данных профиля</h4>
                </div>
                
                <div class="card-body">
                    
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <strong>Ошибка!</strong> Пожалуйста, проверьте введенные данные.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="bi bi-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                   
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT') 

                        
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2 mb-3">Основная информация</h5>
                            
                            <div class="row">
                                
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">
                                        <i class="bi bi-person me-1"></i> Имя *
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name', $user->name) }}"
                                           placeholder="Введите ваше имя"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">
                                        <i class="bi bi-envelope me-1"></i> Email *
                                    </label>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email', $user->email) }}"
                                           placeholder="example@mail.com"
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">
                                        <i class="bi bi-telephone me-1"></i> Телефон
                                    </label>
                                    <input type="tel" 
                                           class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" 
                                           name="phone" 
                                           value="{{ old('phone', $user->phone) }}"
                                           placeholder="+7 (999) 123-45-67">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Необязательное поле</div>
                                </div>
                            </div>
                        </div>

                      
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2 mb-3">Смена пароля</h5>
                            <p class="text-muted small mb-4">
                                <i class="bi bi-info-circle me-1"></i>
                                Заполняйте эти поля только если хотите изменить пароль
                            </p>
                            
                            <div class="row">
                               
                                <div class="col-md-6 mb-3">
                                    <label for="current_password" class="form-label">
                                        Текущий пароль
                                    </label>
                                    <input type="password" 
                                           class="form-control @error('current_password') is-invalid @enderror" 
                                           id="current_password" 
                                           name="current_password"
                                           placeholder="Введите текущий пароль">
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                
                                <div class="col-md-6 mb-3">
                                    <label for="new_password" class="form-label">
                                        Новый пароль
                                    </label>
                                    <input type="password" 
                                           class="form-control @error('new_password') is-invalid @enderror" 
                                           id="new_password" 
                                           name="new_password"
                                           placeholder="Минимум 8 символов">
                                    @error('new_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                
                                <div class="col-md-6 mb-3">
                                    <label for="new_password_confirmation" class="form-label">
                                        Подтверждение пароля
                                    </label>
                                    <input type="password" 
                                           class="form-control" 
                                           id="new_password_confirmation" 
                                           name="new_password_confirmation"
                                           placeholder="Повторите новый пароль">
                                    <div class="form-text">Пароли должны совпадать</div>
                                </div>
                            </div>
                        </div>

                        <!-- Кнопки -->
                        <div class="d-flex justify-content-between align-items-center mt-5">
                            <a href="{{ route('profile.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Назад
                            </a>
                            
                            <div>
                                <button type="reset" class="btn btn-outline-secondary me-2">
                                    <i class="bi bi-x-circle me-1"></i> Сбросить
                                </button>
                                <button type="submit" class="btn btn-secondary">
                                    <i class="bi bi-check-circle me-1"></i> Сохранить изменения
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Дополнительная информация -->
            <div class="card shadow-sm mt-4">
                <div class="card-body">
                    <h6><i class="bi bi-info-circle me-2 text-danger"></i> Важная информация</h6>
                    <ul class="small text-muted mb-0">
                        <li>Поля помеченные * обязательны для заполнения</li>
                        <li>После изменения email потребуется подтверждение</li>
                        <li>Пароль должен содержать минимум 8 символов</li>
                        <li>Изменения вступают в силу сразу после сохранения</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection