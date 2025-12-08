<?php
// app/Models/Cart.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'session_id'];

    // Элементы корзины
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    // Пользователь (если есть)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Получить текущую корзину (из сессии или БД)
    public static function getCurrentCart()
    {
        // Если пользователь авторизован - ищем по user_id
        if (auth()->check()) {
            return self::firstOrCreate([
                'user_id' => auth()->id()
            ]);
        }
        
        // Если не авторизован - ищем по session_id
        return self::firstOrCreate([
            'session_id' => session()->getId()
        ]);
    }

    // Подсчет общей суммы
    public function getTotalAttribute()
    {
        return $this->items->sum(function($item) {
            return $item->price * $item->quantity;
        });
    }

    // Подсчет количества позиций
    public function getItemsCountAttribute()
    {
        return $this->items->sum('quantity');
    }
}