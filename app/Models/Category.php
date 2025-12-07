<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
     protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'sort_order',
        'is_active'
    ];
    
     public function dishes()
    {
        return $this->hasMany(Dish::class);
    }
}
