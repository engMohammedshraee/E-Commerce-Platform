<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CheckController;
use App\Http\Controllers\User\ProdutListController;
use App\Http\Controllers\UserController;
use Inertia\Inertia;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\redirectMiddleware;
use App\Http\Controllers\Admin\AdminContoroller;
use App\Http\Controllers\Admin\AdminAuthContoroller;

//user route
Route::get('/', [UserController::class, 'index'])->name('user.home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->middleware(redirectMiddleware::class)->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //ckeck controller
    Route::prefix('ckeck')->controller(CheckController::class)->group(function () {
        Route::post('order', 'store')->name('check.store');
        Route::get('/success','success')->name('check.success');
        Route::get('/cancel', fn() => '❌ تم إلغاء العملية')->name('payment.cancel');
    });
});
//end user route

//admin auth
Route::group([
    'middleware' => RedirectMiddleware::class
], function () {
    Route::get('login', [AdminAuthContoroller::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminAuthContoroller::class, 'login'])->name('admin.login.post');
    Route::post('logout', [AdminAuthContoroller::class, 'logout'])->name('admin.logout');
});
//Admin rout
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/Dashboard', [AdminContoroller::class, 'index'])->name('admin.dashboard');
    Route::resource('products', ProductController::class);
    Route::delete('/products/images/{id}', [ProductController::class, 'deleteImage'])->name('product.image.delete');
    Route::delete('/productsdelete/{id}', [ProductController::class, 'deleteproduct'])->name('product.delete');
})->middleware(AdminMiddleware::class);
//end admin route
//cart controoler
Route::prefix('cart')->controller(CartController::class)->group(function () {
    Route::get('view', 'view')->name('cart.view');
    Route::post('store/{product}', 'store')->name('cart.store');
    Route::patch('update/{product}', 'update')->name('cart.update');
    Route::delete('delete/{product}', 'delete')->name('cart.delete');
});
// route product list contriller
Route::prefix('product')->controller(ProdutListController::class)->group(function () {
    Route::get('/LIST', 'index')->name('product.index');
});

require __DIR__ . '/auth.php';
