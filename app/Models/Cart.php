<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];

    
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

  
    public function user()
    {
        return $this->belongsTo(User::class);
    }

   
    public static function getCurrentCart()
    {
      
        if (auth()->check()) {
            return self::firstOrCreate([
                'user_id' => auth()->id()
            ]);
        }
        
       
        return self::firstOrCreate([
            'session_id' => session()->getId()
        ]);
    }

   
    public function getTotalAttribute()
    {
        return $this->items->sum(function($item) {
            return $item->price * $item->quantity;
        });
    }

  
    public function getItemsCountAttribute()
    {
        return $this->items->sum('quantity');
    }
}