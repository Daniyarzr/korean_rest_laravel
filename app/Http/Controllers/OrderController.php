<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Dish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Страница оформления заказа
    public function checkout()
    {
        // Получаем данные корзины
        $cartController = new CartController();
        $cartData = $cartController->getCartData();
        
        if ($cartData['items_count'] == 0) {
            return redirect()->route('cart.index')
                ->with('error', 'Ваша корзина пуста!');
        }
        
        return view('orders.checkout', $cartData);
    }
    
    // Создать заказ
    public function store(Request $request)
    {
        // Валидация
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'delivery_address' => 'required|string|max:500',
            'payment_method' => 'required|in:cash,card',
            'notes' => 'nullable|string|max:1000',
        ]);
        
        // Получаем корзину
        $cartController = new CartController();
        $cartData = $cartController->getCartData();
        
        if ($cartData['items_count'] == 0) {
            return back()->with('error', 'Корзина пуста!');
        }
        
        // Создаем заказ
        $order = Order::create([
            'user_id' => auth()->id(),
            'customer_name' => $validated['customer_name'],
            'phone' => $validated['phone'],  
            'delivery_address' => $validated['delivery_address'],
            'total' => $cartData['total'],
            'payment_method' => $validated['payment_method'],
            'notes' => $validated['notes'] ?? null,
            'status' => 'new'
        ]);
        
        // Добавляем товары в заказ
        foreach ($cartData['items'] as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'dish_id' => $item->dish_id,
                'quantity' => $item->quantity,
                'price' => $item->price
            ]);
        }
        
        // Очищаем корзину
        $cartController->clear();
        
        // Редирект на страницу успешного оформления
        return redirect()->route('orders.success', $order)
            ->with('success', 'Заказ успешно оформлен!');
    }
    
    // Страница успешного оформления
    public function success(Order $order)
    {
        // Проверяем, что заказ принадлежит пользователю
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        
        return view('orders.success', compact('order'));
    }

    // Отмена заказа
    public function cancel(Order $order)
    {
        // Проверяем права
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        
        // Используем метод cancel из модели Order
        if ($order->cancel()) {
            return back()->with('success', 'Заказ успешно отменен');
        }
        
        return back()->with('error', 'Не удалось отменить заказ');
    }
}