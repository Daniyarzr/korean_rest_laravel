<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    // Главная страница личного кабинета
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    // Страница редактирования профиля
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    // Обновление профиля
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 
                       Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'current_password' => ['nullable', 'required_with:new_password'],
            'new_password' => ['nullable', 'min:8', 'confirmed'],
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Обновляем основные данные
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        
        // Обновляем пароль, если введен новый
        if ($request->new_password) {
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()
                    ->withErrors(['current_password' => 'Текущий пароль неверен'])
                    ->withInput();
            }
            $user->password = Hash::make($request->new_password);
        }
        
        $user->save();
        
        return redirect()->route('profile.index')
            ->with('success', 'Профиль успешно обновлен!');
    }

    // История заказов (пока заглушка)
    public function orders()
    {
        $user = Auth::user();
        // Здесь позже добавим получение реальных заказов
        $orders = []; // Заглушка
        
        return view('profile.orders', compact('user', 'orders'));
    }

    // Адреса доставки (пока заглушка)
    public function addresses()
    {
        $user = Auth::user();
        // Здесь позже добавим получение адресов
        $addresses = []; // Заглушка
        
        return view('profile.addresses', compact('user', 'addresses'));
    }
}