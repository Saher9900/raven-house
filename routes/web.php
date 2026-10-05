<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PerfumeAdminController;
use App\Http\Controllers\Admin\PerfumeCategoryController;
use App\Http\Controllers\Admin\SunglassesAdminController;
use App\Http\Controllers\Admin\SunglassesCategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PerfumeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SunglassesController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('perfumes', [PerfumeController::class, 'index'])->name('perfumes.page');
Route::get('perfumes/{perfume}', [PerfumeController::class, 'show'])->name('perfumes.show');

Route::get('sunglasses', [SunglassesController::class, 'index'])->name('sunglasses.page');
Route::get('sunglasses/{sunglasses}', [SunglassesController::class, 'show'])->name('sunglasses.show');

Route::view('contact', 'website.pages.contact')->name('contact.page');
Route::view('about', 'website.pages.about')->name('about.page');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

Route::post('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('cart', [CartController::class, 'store'])->name('cart.store');
    Route::patch('cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('cart/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::post('checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    
    Route::patch('profile/address', [ProfileController::class, 'updateAddress'])->name('profile.update-address');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');

    // User Management - Only Manager can access
    Route::middleware('manager')->group(function () {
        Route::resource('users', UserController::class);
    });

    // Perfume Management - Admin and Manager
    Route::resource('perfumes', PerfumeAdminController::class);
    Route::resource('perfume-categories', PerfumeCategoryController::class);

    // Sunglasses Management - Admin and Manager
    Route::resource('sunglasses', SunglassesAdminController::class);
    Route::resource('sunglasses-categories', SunglassesCategoryController::class);

    // Image Management
    Route::delete('images/{image}', [ImageController::class, 'destroy'])->name('image.delete');
});