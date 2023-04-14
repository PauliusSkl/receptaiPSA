<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('guest');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('player.home');
    })->name('dashboard');
});


route::get('/redirect', [HomeController::class, 'redirect']);


// All products
Route::get('/admin/products', [ProductController::class, 'index'])->middleware('auth')->middleware('is_admin');

// Store product
Route::post('/admin/products', [ProductController::class, 'store'])->middleware('auth');

// Show create form
Route::get('/admin/products/create', [ProductController::class, 'create'])->middleware('auth');

// Show product delete page
Route::get('/admin/products/{product}/delete', [ProductController::class, 'show'])->middleware('auth');

// Delete product
Route::delete('/admin/products/{product}/delete', [ProductController::class, 'destroy'])->middleware('auth');

// Edit product
Route::get('/admin/products/{product}/edit', [ProductController::class, 'edit'])->middleware('auth');

// Update product
Route::put('/admin/products/{product}/edit', [ProductController::class, 'update'])->middleware('auth');
