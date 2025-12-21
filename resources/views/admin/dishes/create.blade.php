@extends('admin.layout')

@section('title', 'Создать блюдо')

@section('content')
    <div class="page-header">
        <h1>Создать блюдо</h1>
        <a class="btn" href="{{ route('admin.dishes.index') }}">← Назад к списку</a>
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
        <form method="POST" action="{{ route('admin.dishes.store') }}">
            @csrf

            <div class="form-group">
                <label for="name">Название блюда *</label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name') }}" 
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
                       value="{{ old('price') }}" 
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
                          placeholder="Подробное описание блюда...">{{ old('description') }}</textarea>
                <small>Необязательное поле</small>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn primary">Создать блюдо</button>
                <a class="btn" href="{{ route('admin.dishes.index') }}">Отмена</a>
            </div>
        </form>
    </div>
@endsection
