<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    protected $fillable = [
        'name',
        'description', 
        'price',
        'url_image',
        'is_spicy',
        'is_vegetarian',
        'is_active'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
