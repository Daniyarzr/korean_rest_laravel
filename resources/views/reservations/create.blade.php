@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Забронировать столик</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('reservations.store') }}">
        @csrf

           <div class="mb-3">
                <label>Имя</label>
                <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
                <small class="text-muted">Имя берется из вашего профиля</small>
            </div>

            
            <input type="hidden" name="name" value="{{ auth()->user()->name }}">


        <div class="mb-3">
            <label>Телефон</label>
            <input type="tel" name="phone" class="form-control" value="{{ old('phone') }}" required>
        </div>

        <div class="mb-3">
            <label>Дата</label>
            <select name="date" id="res-date" class="form-control" required>
                @foreach($dates as $date)
                    <option value="{{ $date['value'] }}" {{ old('date', $today) === $date['value'] ? 'selected' : '' }}>
                        {{ $date['label'] }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Время</label>
            <select name="time" id="res-time" class="form-control" required>
                @foreach($timesToday as $time)
                    <option value="{{ $time }}" {{ old('time') === $time ? 'selected' : '' }}>
                        {{ $time }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Количество гостей</label>
            <input type="number" name="guests" class="form-control" min="1" max="20" value="{{ old('guests', 2) }}" required>
        </div>

        <div class="mb-3">
            <label>Комментарий (необязательно)</label>
            <textarea name="comment" class="form-control" rows="3">{{ old('comment') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Забронировать</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dateSelect = document.getElementById('res-date');
        const timeSelect = document.getElementById('res-time');
        const timesToday = @json($timesToday);
        const otherTimes = @json($times);
        const today = @json($today);
        const oldTime = @json(old('time'));

        function updateTimes() {
            const selectedDate = dateSelect.value;
            const times = (selectedDate === today) ? timesToday : otherTimes;
            
            timeSelect.innerHTML = '';
            
            if (times.length === 0) {
                timeSelect.innerHTML = '<option value="">Нет доступного времени</option>';
                return;
            }
            
            times.forEach(time => {
                const option = new Option(time, time);
                timeSelect.add(option);
            });
            
            if (oldTime && times.includes(oldTime)) {
                timeSelect.value = oldTime;
            }
        }

        dateSelect.addEventListener('change', updateTimes);
        updateTimes();
    });
</script>
@endsection