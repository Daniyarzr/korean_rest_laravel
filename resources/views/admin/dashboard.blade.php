@extends('admin.layout')

@section('title', 'Админка')

@section('content')
    <h1 class="text-2xl font-bold">Панель администратора</h1>

    <div class="mt-4 grid gap-4">
        <div class="p-4 border rounded">
            <div class="text-sm text-gray-500">Вы вошли как</div>
            <div class="font-semibold">{{ auth()->user()->email }}</div>
            <div class="text-sm">role: {{ auth()->user()->role }}</div>
        </div>

        <div class="p-4 border rounded">
            <div class="font-semibold">Разделы</div>
            <ul class="list-disc ml-5 mt-2">
                <li><a href="{{route('admin.users.index')}}" class="underline">Пользователи</a></li>
                <li><a href="{{route('admin.dishes.index')}}" class="underline">Блюда</a></li>
                <li><a href="#" class="underline">Настройки</a></li>
            </ul>
        </div>
    </div>
@endsection
