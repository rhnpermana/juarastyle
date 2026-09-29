<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Semua route web didefinisikan di sini.
|
*/

// Halaman utama
Route::get('/', function () {
    $products = \App\Models\Product::where('is_active', true)->get();
    return view('welcome', ['user' => auth()->user(), 'products' => $products]);
});

// Login & Logout
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Hanya bisa diakses setelah login
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // User cart routes
    Route::get('/checkout', [UserController::class, 'checkout'])->name('user.checkout');
    Route::post('/process-payment', [UserController::class, 'processPayment'])->name('user.process-payment');
    Route::get('/receipt/{transaction}', [UserController::class, 'receipt'])->name('user.receipt');
    Route::post('/add-to-cart', [UserController::class, 'addToCart'])->name('add-to-cart');

    // Cashier routes
    Route::middleware('cashier')->prefix('cashier')->name('cashier.')->group(function () {
        Route::get('/', [CashierController::class, 'index'])->name('index');
        Route::post('/add-to-cart', [CashierController::class, 'addToCart'])->name('add-to-cart');
        Route::delete('/remove-from-cart/{productId}', [CashierController::class, 'removeFromCart'])->name('remove-from-cart');
        Route::put('/update-cart', [CashierController::class, 'updateCart'])->name('update-cart');
        Route::delete('/clear-cart', [CashierController::class, 'clearCart'])->name('clear-cart');
        Route::post('/checkout', [CashierController::class, 'checkout'])->name('checkout');
        Route::get('/receipt/{transaction}', [CashierController::class, 'receipt'])->name('receipt');
        Route::get('/history', [CashierController::class, 'history'])->name('history');
    });
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');

    // Product management routes
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::get('/products/create', [AdminController::class, 'createProduct'])->name('create-product');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('store-product');
    Route::get('/products/{id}/edit', [AdminController::class, 'editProduct'])->name('edit-product');
    Route::put('/products/{id}', [AdminController::class, 'updateProduct'])->name('update-product');
    Route::delete('/products/{id}', [AdminController::class, 'deleteProduct'])->name('delete-product');
});
