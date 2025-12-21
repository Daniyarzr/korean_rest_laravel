@extends('admin.layout')

@section('title', 'Создать пользователя')

@section('content')
    <div class="page-header">
        <h1>Создать пользователя</h1>
        <a class="btn" href="{{ route('admin.users.index') }}">← Назад к списку</a>
    </div>

    @if ($errors->any())
        <div class="alert error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf

            <div class="form-group">
                <label for="name">Имя *</label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name') }}" 
                       placeholder="Введите имя пользователя" 
                       required 
                       autofocus>
                <small>Максимум 255 символов</small>
            </div>

            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       placeholder="user@example.com" 
                       required>
                <small>Должен быть уникальным</small>
            </div>

            <div class="form-group">
                <label for="password">Пароль *</label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       placeholder="Минимум 6 символов" 
                       required>
                <small>Минимум 6 символов</small>
            </div>

            <div class="form-group">
                <label for="role">Роль *</label>
                <select id="role" name="role" required>
                    <option value="" disabled selected>Выберите роль</option>
                    @foreach($roles as $role)
                        <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>
                            {{ ucfirst($role) }}
                        </option>
                    @endforeach
                </select>
                <small>admin — полный доступ, manager — ограниченный, user — базовый</small>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn primary">Создать пользователя</button>
                <a class="btn" href="{{ route('admin.users.index') }}">Отмена</a>
            </div>
        </form>
    </div>
@endsection
