@extends('admin.layout')

@section('title', 'Редактировать блюдо')

@section('content')
    <div class="page-header">
        <h1>Редактировать блюдо #{{ $dish->id }}</h1>
        <a class="btn" href="{{ route('admin.dishes.index') }}">← Назад к списку</a>
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
        <form method="POST" action="{{ route('admin.dishes.update', $dish) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Название блюда *</label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $dish->name) }}" 
                       placeholder="Например: Пицца Маргарита" 
                       required 
                       autofocus>
                <small>Максимум 255 символов</small>
            </div>

            <div class="form-group">
                <label for="price">Цена *</label>
                <input type="number" 
                       id="price" 
                       name="price" 
                       value="{{ old('price', $dish->price) }}" 
                       placeholder="0" 
                       min="0" 
                       step="1" 
                       required>
                <small>Цена в рублях</small>
            </div>

            <div class="form-group">
                <label for="description">Описание</label>
                <textarea id="description" 
                          name="description" 
                          rows="4" 
                          placeholder="Подробное описание блюда...">{{ old('description', $dish->description) }}</textarea>
                <small>Необязательное поле</small>
            </div>

            <div class="dish-info mt-4 p-3 bg-gray-50 rounded">
                <h3 class="font-semibold">Информация о блюде</h3>
                <p><strong>Создано:</strong> {{ $dish->created_at->format('d.m.Y H:i') }}</p>
                <p><strong>Обновлено:</strong> {{ $dish->updated_at->format('d.m.Y H:i') }}</p>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn primary">Сохранить изменения</button>
                <a class="btn" href="{{ route('admin.dishes.index') }}">Отмена</a>
                
                <form method="POST" 
                      action="{{ route('admin.dishes.destroy', $dish) }}" 
                      class="inline-form"
                      onsubmit="return confirm('Вы уверены, что хотите удалить это блюдо?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn danger">Удалить блюдо</button>
                </form>
            </div>
        </form>
    </div>
@endsection
