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
        <form method="POST" action="{{ route('admin.dishes.update', $dish) }}" enctype="multipart/form-data">
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
                <label for="category_id">Категория *</label>
                <select id="category_id" name="category_id" required>
                    <option value="">Выберите категорию</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $dish->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <small>Выберите категорию для блюда</small>
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

            <div class="form-group">
                <label>Текущее изображение</label>
                @if($dish->url_image)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $dish->url_image) }}" 
                             alt="{{ $dish->name }}"
                             style="max-width: 320px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.15);">
                    </div>
                @else
                    <p class="text-gray-500">Изображения пока нет</p>
                @endif
                
                <label for="image">Заменить изображение</label>
                <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/webp">
                <small>Рекомендуемый размер: 800×600 px. JPG, PNG, WEBP. Макс. 5 МБ. Оставьте пустым, если не хотите менять.</small>
            </div>

            <div class="dish-info mt-4 p-3 bg-gray-50 rounded">
                <h3 class="font-semibold">Информация о блюде</h3>
                <p><strong>Создано:</strong> {{ $dish->created_at->format('d.m.Y H:i') }}</p>
                <p><strong>Обновлено:</strong> {{ $dish->updated_at->format('d.m.Y H:i') }}</p>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn primary">Сохранить изменения</button>
                <a class="btn" href="{{ route('admin.dishes.index') }}">Отмена</a>
            </div>
        </form>

        <!-- Форма удаления вынесена ВНЕ формы редактирования -->
        <form method="POST" 
              action="{{ route('admin.dishes.destroy', $dish) }}" 
              class="inline-form"
              onsubmit="return confirm('Вы уверены, что хотите удалить это блюдо?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn danger">Удалить блюдо</button>
        </form>
    </div>
@endsection