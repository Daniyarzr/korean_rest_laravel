<?php
// app/Http\Controllers/CartController.php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Dish;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // ============= 1. ПОКАЗАТЬ КОРЗИНУ =============
    public function index()
    {
        // Получаем текущую корзину пользователя
        $cart = $this->getCurrentCart();
        
        // Обновляем счетчик в сессии
        $this->updateCartCount($cart);
        
        // Передаем в представление 'cart.index'
        return view('cart.index', compact('cart'));
    }
    
    // ============= 2. ДОБАВИТЬ БЛЮДО В КОРЗИНУ =============
    public function add(Request $request, Dish $dish)
    {
        $request->validate([
            'quantity' => 'integer|min:1|max:10',
        ]);

        $quantity = $request->quantity ?? 1;
        $cart = $this->getCurrentCart();

        // Проверяем, есть ли уже это блюдо в корзине
        $cartItem = $cart->items()->where('dish_id', $dish->id)->first();

        if ($cartItem) {
            // Если есть - увеличиваем количество
            $cartItem->increment('quantity', $quantity);
        } else {
            // Если нет - создаем новую запись
            $cart->items()->create([
                'dish_id' => $dish->id,
                'quantity' => $quantity,
                'price' => $dish->price,
            ]);
        }
        
        // Обновляем счетчик
        $this->updateCartCount($cart);

        return redirect()->route('cart.index')
            ->with('success', 'Блюдо добавлено в корзину!');
    }
    
    // ============= 3. ОБНОВИТЬ КОЛИЧЕСТВО =============
    public function update(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        $cart = $this->getCurrentCart();
        $item = $cart->items()->findOrFail($itemId);
        $item->update(['quantity' => $request->quantity]);
        
        // Обновляем счетчик
        $this->updateCartCount($cart);

        return redirect()->route('cart.index')
            ->with('success', 'Корзина обновлена!');
    }
    
    // ============= 4. УДАЛИТЬ БЛЮДО ИЗ КОРЗИНЫ =============
    public function remove($itemId)
    {
        $cart = $this->getCurrentCart();
        $item = $cart->items()->findOrFail($itemId);
        $item->delete();
        
        // Обновляем счетчик
        $this->updateCartCount($cart);

        return redirect()->route('cart.index')
            ->with('success', 'Блюдо удалено из корзины!');
    }
    
    // ============= 5. ОЧИСТИТЬ КОРЗИНУ =============
    public function clear()
    {
        $cart = $this->getCurrentCart();
        $cart->items()->delete();
        
        // Обновляем счетчик
        $this->updateCartCount($cart);

        return redirect()->route('cart.index')
            ->with('success', 'Корзина очищена!');
    }
    
    // ============= ВСПОМОГАТЕЛЬНЫЕ МЕТОДЫ =============
    
    // Получить текущую корзину
    private function getCurrentCart()
    {
        return \App\Models\Cart::getCurrentCart();
    }
    
    // Обновить счетчик в сессии
    private function updateCartCount($cart)
    {
        $count = $cart->fresh()->items->sum('quantity');
        session(['cart_count' => $count]);
    }
}