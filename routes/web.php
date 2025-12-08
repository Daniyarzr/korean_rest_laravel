<?php

use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;

Auth::routes();


Route::get('/', [MenuController::class, 'home'])->name('home');


Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::get('/menu/{category:slug}', [MenuController::class, 'category'])->name('menu.category');
Route::get('/dish/{dish}', [MenuController::class, 'show'])->name('menu.show');

// Личный кабинет
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/orders', [App\Http\Controllers\ProfileController::class, 'orders'])->name('profile.orders');
    Route::get('/profile/addresses', [App\Http\Controllers\ProfileController::class, 'addresses'])->name('profile.addresses');
});

Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add/{dish}', [CartController::class, 'add'])->name('cart.add');
    Route::put('/update/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/remove/{item}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('cart.clear');
});