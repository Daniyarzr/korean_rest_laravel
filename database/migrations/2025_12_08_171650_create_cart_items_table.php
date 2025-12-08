<?php
// database/migrations/[дата]_create_cart_items_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')
                  ->constrained('carts')
                  ->onDelete('cascade');
            $table->foreignId('dish_id')
                  ->constrained('dishes')
                  ->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->decimal('price', 8, 2);
            $table->timestamps();
            
            // Уникальный индекс: блюдо может быть в корзине только один раз
            $table->unique(['cart_id', 'dish_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};