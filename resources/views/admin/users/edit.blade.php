@extends('admin.layout')

@section('title', 'Редактировать пользователя')

@section('content')
    <div class="page-header">
        <h1>Редактировать пользователя #{{ $user->id }}</h1>
        <a class="btn" href="{{ route('admin.users.index') }}">← Назад к списку</a>
    </div>

    @if (session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif

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
        <!-- Форма редактирования -->
        <form method="POST" action="{{ route('admin.users.update', $user) }}" id="editForm">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Имя *</label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $user->name) }}" 
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
                       value="{{ old('email', $user->email) }}" 
                       placeholder="user@example.com" 
                       required>
                <small>Должен быть уникальным</small>
            </div>

            <div class="form-group">
                <label for="password">Пароль</label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       placeholder="Оставьте пустым, если не меняется">
                <small>Минимум 6 символов. Заполняйте только для смены пароля</small>
            </div>

            <div class="form-group">
                <label for="role">Роль *</label>
                <select id="role" name="role" required>
                    @foreach($roles as $role)
                        <option value="{{ $role }}" {{ (old('role', $user->role) == $role) ? 'selected' : '' }}>
                            {{ ucfirst($role) }}
                        </option>
                    @endforeach
                </select>
                <small>admin — полный доступ, manager — ограниченный, user — базовый</small>
            </div>

            <div class="user-info mt-4 p-3 bg-gray-50 rounded">
                <h3 class="font-semibold">Информация о пользователе</h3>
                <p><strong>Создан:</strong> {{ $user->created_at->format('d.m.Y H:i') }}</p>
                <p><strong>Обновлён:</strong> {{ $user->updated_at->format('d.m.Y H:i') }}</p>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn primary">Сохранить изменения</button>
                <a class="btn" href="{{ route('admin.users.index') }}">Отмена</a>
            </div>
        </form>

        <!-- Форма удаления - ОТДЕЛЬНО, после формы редактирования -->
        @if(auth()->id() !== $user->id)
            <div class="mt-6 pt-6 border-t border-gray-200">
                <h3 class="font-semibold text-red-600 mb-2">Опасная зона</h3>
                <form method="POST" 
                      action="{{ route('admin.users.destroy', $user) }}"
                      onsubmit="return confirm('Вы уверены, что хотите удалить пользователя {{ $user->name }}? Это действие нельзя отменить.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn danger">Удалить пользователя</button>
                    <span class="text-sm text-gray-500 ml-2">Это действие необратимо</span>
                </form>
            </div>
        @else
            <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded">
                <p class="text-yellow-700">
                    <strong>Внимание:</strong> Вы не можете удалить свой собственный аккаунт.
                </p>
            </div>
        @endif
    </div>
@endsection