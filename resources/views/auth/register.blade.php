@extends('layouts.app')

@section('title', 'Регистрация')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4">Регистрация</h2>
                    
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Имя -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Имя</label>
                            <input id="name" type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">{{ __('Phone Number') }}</label>
                            <input id="phone" type="tel" class="form-control" name="phone">
                            <small class="form-text text-muted">{{ __('Optional') }}</small>
                        </div>
                        <!-- Пароль -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Пароль</label>
                            <input id="password" type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   name="password" required autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Подтверждение пароля -->
                        <div class="mb-4">
                            <label for="password-confirm" class="form-label">Подтвердите пароль</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <!-- Кнопка регистрации -->
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-dark btn-lg">Зарегистрироваться</button>
                        </div>

                        <!-- Ссылка на вход -->
                        <div class="text-center">
                            <span class="text-muted">Уже есть аккаунт?</span>
                            <a href="{{ route('login') }}" class="ms-2">Войти</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection