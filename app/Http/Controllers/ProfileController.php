<?php

namespace App\Http\Controllers;

use App\Models\Order;
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
        $orders = Order::where('user_id', auth()->id())->get();
        $act_orders = Order::where('user_id', auth()->id())->where('status', 'new')->get();
        return view('profile.index', compact('user', 'orders','act_orders'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

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
        

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        
       
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

   
    public function orders()
    {
        $orders = Order::where('user_id', auth()->id())
        ->with('items.dish')
        ->orderByRaw("CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END") 
        ->orderBy('created_at', 'desc') 
        ->get();
        
        
        $totalOrders = $orders->count();
        $activeOrders = $orders->whereIn('status', ['new', 'processing'])->count();
        
        return view('profile.orders', compact('orders'));
    }

    public function orderShow(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        
        $order->load('items.dish');
        
        return view('profile.order-show', compact('order'));
    }

    public function reservations()
    {
        $reservations = auth()->user()
            ->reservations()
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->paginate(10);

        return view('profile.reservations', compact('reservations'));
    }
   
    public function addresses()
    {
        $user = Auth::user();
        $addresses = []; 
        
        return view('profile.addresses', compact('user', 'addresses'));
    }
}