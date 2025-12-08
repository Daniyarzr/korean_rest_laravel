<?php
// app/Http/Controllers/CartController.php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Dish;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Показать корзину
    public function index()
    {
        $cart = $this->getCurrentCart();
        return view('cart.index', compact('cart'));
    }

    // Добавить блюдо в корзину
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
                'price' => $dish->price, // Сохраняем текущую цену
            ]);
        }

        return redirect()->route('cart.index')
            ->with('success', 'Блюдо добавлено в корзину!');
    }

    // Обновить количество
    public function update(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        $cart = $this->getCurrentCart();
        $item = $cart->items()->findOrFail($itemId);
        $item->update(['quantity' => $request->quantity]);

        return redirect()->route('cart.index')
            ->with('success', 'Корзина обновлена!');
    }

    // Удалить блюдо из корзины
    public function remove($itemId)
    {
        $cart = $this->getCurrentCart();
        $item = $cart->items()->findOrFail($itemId);
        $item->delete();

        return redirect()->route('cart.index')
            ->with('success', 'Блюдо удалено из корзины!');
    }

    // Очистить корзину
    public function clear()
    {
        $cart = $this->getCurrentCart();
        $cart->items()->delete();

        return redirect()->route('cart.index')
            ->with('success', 'Корзина очищена!');
    }

    // ===== ВСПОМОГАТЕЛЬНЫЙ МЕТОД =====
    
    // Получить текущую корзину (из БД)
    private function getCurrentCart()
    {
        return Cart::getCurrentCart();
    }
}