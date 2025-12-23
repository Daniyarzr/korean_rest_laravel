@extends('admin.layout')

@section('title', 'Админ панель|Пользователи')

@section('content')
    <div class="page-header">
        <h1>Пользователи</h1>

        <div class="actions">
            <form method="GET" class="search">
                <input type="text" name="q" value="{{ $q }}" placeholder="Поиск по имени/email">
                <button type="submit">Найти</button>
            </form>

            <a class="btn" href="{{ route('admin.users.create') }}">+ Создать</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert error">{{ session('error') }}</div>
    @endif

    <div class="card">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Email</th>
                    <th>Роль</th>
                    <th style="width: 220px;">Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>#{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td><span class="badge">{{ $user->role }}</span></td>
                        <td class="row-actions">
                            <a class="btn small" href="{{ route('admin.users.edit', $user) }}">Редактировать</a>

                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                  onsubmit="return confirm('Удалить пользователя?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn small danger" type="submit">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5">Ничего не найдено.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt">
        {{ $users->links() }}
    </div>
@endsection
