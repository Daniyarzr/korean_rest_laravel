<?php
// app/Http/Controllers/CartController.php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Dish;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // ============= ПОКАЗАТЬ КОРЗИНУ =============
    public function index()
    {
        // Получаем корзину (из сессии или БД)
        $cartData = $this->getCartData();
        
        return view('cart.index', $cartData);
    }
    
    // ============= ДОБАВИТЬ БЛЮДО =============
    public function add(Request $request, Dish $dish)
    {
        $request->validate([
            'quantity' => 'integer|min:1|max:10',
        ]);
        
        $quantity = $request->quantity ?? 1;
        
        // ЕСЛИ авторизован - работаем с БД
        if (auth()->check()) {
            $this->addToDatabaseCart($dish, $quantity);
        } 
        // ЕСЛИ гость - работаем с сессией
        else {
            $this->addToSessionCart($dish, $quantity);
        }
        
        return redirect()->back()
            ->with('success', 'Блюдо добавлено в корзину!');
    }
    
    // ============= ОБНОВИТЬ КОЛИЧЕСТВО =============
    public function update(Request $request, $dishId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10',
        ]);
        
        if (auth()->check()) {
            $this->updateDatabaseCart($dishId, $request->quantity);
        } else {
            $this->updateSessionCart($dishId, $request->quantity);
        }
        
        return redirect()->back()
            ->with('success', 'Корзина обновлена!');
    }
    
    // ============= УДАЛИТЬ БЛЮДО =============
    public function remove($dishId)
    {
        if (auth()->check()) {
            $this->removeFromDatabaseCart($dishId);
        } else {
            $this->removeFromSessionCart($dishId);
        }
        
        return redirect()->back()
            ->with('success', 'Блюдо удалено из корзины!');
    }
    
    // ============= ОЧИСТИТЬ КОРЗИНУ =============
    public function clear()
    {
        if (auth()->check()) {
            $cart = Cart::where('user_id', auth()->id())->first();
            if ($cart) {
                $cart->items()->delete();
            }
        } else {
            session()->forget('cart');
        }
        
        // Сбрасываем счетчик
        session(['cart_count' => 0]);
        
        return redirect()->back()
            ->with('success', 'Корзина очищена!');
    }
    
    // ============= ВСПОМОГАТЕЛЬНЫЕ МЕТОДЫ =============
    
    // Получить данные корзины (для отображения)
    private function getCartData()
    {
        if (auth()->check()) {
            return $this->getDatabaseCart();
        } else {
            return $this->getSessionCart();
        }
    }
    
    // ===== МЕТОДЫ ДЛЯ РАБОТЫ С БАЗОЙ ДАННЫХ (авторизованные) =====
    
    private function addToDatabaseCart($dish, $quantity)
    {
        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
        
        $cartItem = $cart->items()->where('dish_id', $dish->id)->first();
        
        if ($cartItem) {
            $cartItem->increment('quantity', $quantity);
        } else {
            $cart->items()->create([
                'dish_id' => $dish->id,
                'quantity' => $quantity,
                'price' => $dish->price,
            ]);
        }
        
        $this->updateCartCount();
    }
    
    private function updateDatabaseCart($dishId, $quantity)
    {
        $cart = Cart::where('user_id', auth()->id())->first();
        if ($cart) {
            $item = $cart->items()->where('dish_id', $dishId)->first();
            if ($item) {
                $item->update(['quantity' => $quantity]);
            }
        }
        
        $this->updateCartCount();
    }
    
    private function removeFromDatabaseCart($dishId)
    {
        $cart = Cart::where('user_id', auth()->id())->first();
        if ($cart) {
            $item = $cart->items()->where('dish_id', $dishId)->first();
            if ($item) {
                $item->delete();
            }
        }
        
        $this->updateCartCount();
    }
    
    private function getDatabaseCart()
    {
        $cart = Cart::with('items.dish')->where('user_id', auth()->id())->first();
        
        if (!$cart) {
            return [
                'items' => collect([]),
                'total' => 0,
                'items_count' => 0,
                'is_guest' => false
            ];
        }
        
        return [
            'items' => $cart->items,
            'total' => $cart->total,
            'items_count' => $cart->items_count,
            'is_guest' => false
        ];
    }
    
    // ===== МЕТОДЫ ДЛЯ РАБОТЫ С СЕССИЕЙ (гости) =====
    
    private function addToSessionCart($dish, $quantity)
    {
        $cart = session('cart', []);
        
        if (isset($cart[$dish->id])) {
            $cart[$dish->id]['quantity'] += $quantity;
        } else {
            $cart[$dish->id] = [
                'dish_id' => $dish->id,
                'dish' => $dish, // Сохраняем объект блюда
                'quantity' => $quantity,
                'price' => $dish->price,
            ];
        }
        
        session(['cart' => $cart]);
        $this->updateCartCount();
    }
    
    private function updateSessionCart($dishId, $quantity)
    {
        $cart = session('cart', []);
        
        if (isset($cart[$dishId])) {
            $cart[$dishId]['quantity'] = $quantity;
            session(['cart' => $cart]);
        }
        
        $this->updateCartCount();
    }
    
    private function removeFromSessionCart($dishId)
    {
        $cart = session('cart', []);
        
        if (isset($cart[$dishId])) {
            unset($cart[$dishId]);
            session(['cart' => $cart]);
        }
        
        $this->updateCartCount();
    }
    
    private function getSessionCart()
    {
        $cart = session('cart', []);
        $items = collect($cart)->map(function ($item) {
            return (object) [
                'id' => $item['dish_id'],
                'dish_id' => $item['dish_id'],
                'dish' => $item['dish'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $item['price'] * $item['quantity']
            ];
        });
        
        $total = $items->sum('subtotal');
        $itemsCount = $items->sum('quantity');
        
        return [
            'items' => $items,
            'total' => $total,
            'items_count' => $itemsCount,
            'is_guest' => true
        ];
    }
    
    // Обновить счетчик в сессии (общий метод)
    private function updateCartCount()
    {
        $count = 0;
        
        if (auth()->check()) {
            $cart = Cart::where('user_id', auth()->id())->first();
            if ($cart) {
                $count = $cart->items->sum('quantity');
            }
        } else {
            $cart = session('cart', []);
            foreach ($cart as $item) {
                $count += $item['quantity'];
            }
        }
        
        session(['cart_count' => $count]);
    }
}