<?php

use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Admin\DishController as AdminDishController;
use App\Http\Controllers\Admin\UserController as AdminUserController;


Auth::routes();

Route::get('/', [MenuController::class, 'home'])->name('home');

Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::get('/menu/{category:slug}', [MenuController::class, 'category'])->name('menu.category');
Route::get('/dish/{dish}', [MenuController::class, 'show'])->name('menu.show');
Route::get('/contacts', function () {
    return view('contacts');
})->name('contacts.index');


// Корзина (доступна всем)
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add/{dish}', [CartController::class, 'add'])->name('cart.add');
    Route::put('/update/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/remove/{item}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('cart.clear');
});

Route::middleware('auth')->group(function () {
    
    // Личный кабинет
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/orders', [ProfileController::class, 'orders'])->name('profile.orders');
        Route::get('/order-show/{order}', [ProfileController::class, 'orderShow'])->name('profile.order.show');
        Route::get('/reservations', [ProfileController::class, 'reservations'])->name('profile.reservations');
        Route::get('/addresses', [ProfileController::class, 'addresses'])->name('profile.addresses');
    });
    
    // Оформление заказа
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/success/{order}', [OrderController::class, 'success'])->name('orders.success');
    
    // Отмена заказа
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    
    // Бронирования (только для авторизованных)
    Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::patch('/reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])
        ->name('reservations.cancel');
});

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::resource('dishes', AdminDishController::class);
        Route::resource('users', AdminUserController::class);
    });
