<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
    'user_id', 
    'total', 
    'phone', 
    'delivery_address',
    'customer_name', 
    'payment_method', 
    'notes', 
    'status'
];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Отмена заказа 
     public function cancel()
    {
        if ($this->canBeCancelled()) {
            $this->status = 'cancelled';
            $this->save();
            return true;
        }
        return false;
    }
    
    public function canBeCancelled()
    {
        return $this->status === 'new';
    }
    
    // Простой геттер для суммы
    public function getTotalFormattedAttribute()
    {
        return number_format($this->total, 0, '', ' ') . ' ₽';
    }
}