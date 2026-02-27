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
        <form method="POST" action="{{ route('admin.dishes.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name">Название блюда *</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Например: Пицца Маргарита" required autofocus>
                <small>Максимум 255 символов</small>
            </div>

            <div class="form-group">
                <label for="category_id">Категория *</label>
                <select id="category_id" name="category_id" required>
                    <option value="">Выберите категорию</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <small>Выберите категорию для блюда</small>
            </div>

            <div class="form-group">
                <label for="price">Цена *</label>
                <input type="number" id="price" name="price" value="{{ old('price') }}" placeholder="0" min="0" step="1" required>
                <small>Цена в рублях</small>
            </div>

            <div class="form-group">
                <label for="description">Описание</label>
                <textarea id="description" name="description" rows="4" placeholder="Подробное описание блюда...">{{ old('description') }}</textarea>
                <small>Необязательное поле</small>
            </div>

            <div class="form-group">
                <label for="image">Изображение блюда</label>
                <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/webp">
                <small>Рекомендуемый размер: 800×600 px. JPG, PNG, WEBP. Макс. 5 МБ</small>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn primary">Создать блюдо</button>
                <a class="btn" href="{{ route('admin.dishes.index') }}">Отмена</a>
            </div>
        </form>
    </div>
@endsection