<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Shop\HomeController;
use App\Http\Controllers\Shop\ProductController;
use App\Http\Controllers\Shop\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\OrderController;

// ==================== ADMIN ROUTE GROUP ====================
Route::prefix('admin')->middleware(['auth'])->as('admin.')->group(function () {
    // HOME + DASHBOARD
    Route::get('/', [\App\Http\Controllers\Admin\HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // USERS
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    // PRODUCTS
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [AdminProductController::class, 'destroy'])->name('products.destroy');

    // BANNERS
    Route::get('/banners', [BannerController::class, 'index'])->name('banners.index');
    Route::get('/banners/create', [BannerController::class, 'create'])->name('banners.create');
    Route::post('/banners', [BannerController::class, 'store'])->name('banners.store');
    Route::get('/banners/{id}/edit', [BannerController::class, 'edit'])->name('banners.edit');
    Route::put('/banners/{id}', [BannerController::class, 'update'])->name('banners.update');
    Route::delete('/banners/{id}', [BannerController::class, 'destroy'])->name('banners.destroy');
    Route::post('/banners/{id}/toggle-status', [BannerController::class, 'toggleStatus'])->name('banners.toggle-status');

    // BRANDS
    Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');

    // MENUS
    Route::get('/menus', [MenuController::class, 'index'])->name('menus.index');

    // CATEGORIES
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::post('/categories/{id}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');

    // POSTS
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

    // ORDERS
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
});

// ==================== TRANG CHỦ ====================
Route::get('/', [HomeController::class, 'index'])->name('home');

// ==================== SẢN PHẨM ====================
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// ==================== GIỎ HÀNG ====================
Route::get('/cart', [\App\Http\Controllers\Shop\CartController::class, 'index'])->name('cart');
Route::post('/cart/add/{id}', [\App\Http\Controllers\Shop\ProductController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update', [\App\Http\Controllers\Shop\CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [\App\Http\Controllers\Shop\CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [\App\Http\Controllers\Shop\CartController::class, 'clear'])->name('cart.clear');

// ==================== THANH TOÁN ====================
Route::post('/checkout/process', [\App\Http\Controllers\Shop\CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/success/{id}', [\App\Http\Controllers\Shop\CheckoutController::class, 'success'])->name('checkout.success');

// ==================== ĐƠN HÀNG CỦA TÔI ====================
Route::middleware(['auth'])->group(function () {
    Route::get('/my-orders', [\App\Http\Controllers\Shop\OrderController::class, 'index'])->name('my.orders');
    Route::get('/my-orders/{id}', [\App\Http\Controllers\Shop\OrderController::class, 'show'])->name('my.orders.show');

    // PROFILE
    Route::get('/profile', [\App\Http\Controllers\Shop\ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile', [\App\Http\Controllers\Shop\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [\App\Http\Controllers\Shop\ProfileController::class, 'updatePassword'])->name('profile.password');
});

// ==================== XÁC THỰC ====================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');