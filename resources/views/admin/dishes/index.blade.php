@extends('admin.layout')

@section('title', 'Админ панель|Блюда')

@section('content')
    <div class="page-header">
        <h1>Блюда</h1>
        <div class="actions">
            <a class="btn" href="{{ route('admin.dishes.create') }}">+ Создать блюдо</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif

    <div class="card">
        @if($dishes->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th>Описание</th>
                        <th>Цена</th>
                        <th>Дата создания</th>
                        <th style="width: 200px;">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dishes as $dish)
                        <tr>
                            <td>#{{ $dish->id }}</td>
                            <td>{{ $dish->name }}</td>
                            <td>{{ Str::limit($dish->description ?? '—', 50) }}</td>
                            <td>{{ number_format($dish->price, 0, '', ' ') }} ₽</td>
                            <td>{{ $dish->created_at->format('d.m.Y') }}</td>
                            <td class="row-actions">
                                <a class="btn small" href="{{ route('admin.dishes.edit', $dish) }}">
                                    Редактировать
                                </a>
                                
                                <form method="POST" 
                                      action="{{ route('admin.dishes.destroy', $dish) }}"
                                      onsubmit="return confirm('Удалить блюдо?');"
                                      class="inline-form">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn small danger" type="submit">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="p-6 text-center text-gray-500">
                Блюд пока нет. <a href="{{ route('admin.dishes.create') }}" class="underline">Создайте первое блюдо</a>
            </div>
        @endif
    </div>

    <div class="mt-4">
        {{ $dishes->links() }}
    </div>
@endsection
