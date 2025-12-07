@extends('layouts.app')

@section('title', 'Вход')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4">Вход в аккаунт</h2>
                    
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Пароль -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Пароль</label>
                            <input id="password" type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   name="password" required autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Запомнить меня -->
                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">Запомнить меня</label>
                        </div>

                        <!-- Кнопка входа -->
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-dark btn-lg">Войти</button>
                        </div>

                        <!-- Ссылки -->
                        <div class="text-center">
                            @if (Route::has('password.request'))
                                <a class="text-muted" href="{{ route('password.request') }}">Забыли пароль?</a>
                            @endif
                            
                            <div class="mt-3">
                                <span class="text-muted">Нет аккаунта?</span>
                                <a href="{{ route('register') }}" class="ms-2">Зарегистрироваться</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection