<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerAddressController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Catalog\CategoryController as CatalogCategoryController;
use App\Http\Controllers\Catalog\ProductController as CatalogProductController;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Catalog (public)
Route::get('/catalog/categories', [CatalogCategoryController::class, 'index'])->name('catalog.categories.index');
Route::get('/catalog/categories/{id}', [CatalogCategoryController::class, 'show'])->name('catalog.categories.show');
Route::get('/catalog/products', [CatalogProductController::class, 'index'])->name('catalog.products.index');
Route::get('/catalog/products/{id}', [CatalogProductController::class, 'show'])->name('catalog.products.show');

// Cart, checkout, orders, customer (auth required)
Route::middleware('hap.auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/items', [CartController::class, 'addItem'])->name('cart.items.store');
    Route::put('/cart/items/{id}', [CartController::class, 'updateItem'])->name('cart.items.update');
    Route::delete('/cart/items/{id}', [CartController::class, 'removeItem'])->name('cart.items.destroy');
    Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');

    Route::get('/customer/profile', [CustomerController::class, 'profile'])->name('customer.profile');
    Route::put('/customer/profile', [CustomerController::class, 'updateProfile'])->name('customer.profile.update');
    Route::get('/customer/addresses', [CustomerAddressController::class, 'index'])->name('customer.addresses.index');
    Route::get('/customer/addresses/create', [CustomerAddressController::class, 'create'])->name('customer.addresses.create');
    Route::post('/customer/addresses', [CustomerAddressController::class, 'store'])->name('customer.addresses.store');
    Route::get('/customer/addresses/{id}/edit', [CustomerAddressController::class, 'edit'])->name('customer.addresses.edit');
    Route::put('/customer/addresses/{id}', [CustomerAddressController::class, 'update'])->name('customer.addresses.update');
    Route::delete('/customer/addresses/{id}', [CustomerAddressController::class, 'destroy'])->name('customer.addresses.destroy');
});
