<?php
// app/Models/CartItem.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = ['cart_id', 'dish_id', 'quantity', 'price'];

    // Корзина, к которой принадлежит
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    // Блюдо
    public function dish()
    {
        return $this->belongsTo(Dish::class);
    }

    // Подсчет суммы для позиции
    public function getSubtotalAttribute()
    {
        return $this->price * $this->quantity;
    }
}