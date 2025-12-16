<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function create()
    {
        $today = now()->toDateString();
        
        
        $dates = collect(range(0, 6))->map(function ($days) {
            $date = now()->addDays($days);
            
            return [
                'value' => $date->toDateString(),
                'label' => match($days) {
                    0 => 'Сегодня',
                    1 => 'Завтра',
                    default => $date->translatedFormat('D, d.m'),
                }
            ];
        });

     
        $times = $this->getTimeSlots('10:00', '23:00', 30);
        $timesToday = $this->filterTodaySlots($times);

        return view('reservations.create', compact('dates', 'times', 'timesToday', 'today'));
    }

        public function store(Request $request)
    {
        
        $allowedDates = $this->getAllowedDates();
        $allowedTimes = $this->getTimeSlots('10:00', '23:00', 30);
        
       
        $validated = $request->validate([
            
            'phone' => 'required|string|max:30',
            'date' => ['required', Rule::in($allowedDates)],
            'time' => ['required', Rule::in($allowedTimes)],
            'guests' => 'required|integer|min:1|max:20',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Проверка времени для сегодняшней даты
        if ($validated['date'] === now()->toDateString()) {
            $minTime = now()->addMinutes(30)->format('H:i');
            if ($validated['time'] < $minTime) {
                return back()->withErrors(['time' => "Выберите время не раньше $minTime"])->withInput();
            }
        }

        Reservation::create([
            'name' => auth()->user()->name, 
            ...$validated,
            'user_id' => auth()->id(),
            'status' => 'new'
        ]);

        return redirect()->route('profile.reservations')->with('success', 'Столик забронирован!');
    }
    
    public function cancel(Request $request, $id)
    {
        $reservation = Reservation::where('user_id', auth()->id())
            ->where('id', $id)
            ->firstOrFail();

        if (!in_array($reservation->status, ['new', 'confirmed'])) {
            return redirect()->route('profile.reservations')
                ->with('error', 'Это бронирование нельзя отменить.');
        }

        
        $reservation->update(['status' => 'cancelled']);

        return redirect()->route('profile.reservations')
            ->with('success', 'Бронирование успешно отменено.');
    }

    private function getTimeSlots(string $start, string $end, int $step): array
    {
        $slots = [];
        $current = Carbon::createFromFormat('H:i', $start);
        $endTime = Carbon::createFromFormat('H:i', $end);

        while ($current <= $endTime) {
            $slots[] = $current->format('H:i');
            $current->addMinutes($step);
        }

        return $slots;
    }

    private function filterTodaySlots(array $slots): array
    {
        $minTime = now()->addMinutes(30)->format('H:i');
        return array_values(array_filter($slots, fn($time) => $time >= $minTime));
    }

    private function getAllowedDates(): array
    {
        return collect(range(0, 6))
            ->map(fn($days) => now()->addDays($days)->toDateString())
            ->toArray();
    }
}