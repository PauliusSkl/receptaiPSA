<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RecipeController;
use App\Models\Cart;

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
]);
// ->group(function () {
//     Route::get('/dashboard', function () {
//         return view('player.home');
//     })->name('dashboard');
// });


route::get('/redirect', [HomeController::class, 'redirect'])->name('dashboard');

//Profile route
Route::get('/user/profile', [AuthController::class, 'show'])->middleware('auth')->name('profile.show');
//Profile delete produtc
Route::delete('/user/profile/product/{product}/delete', [AuthController::class, 'destroy'])->middleware('auth');

// All products
Route::get('/admin/products', [ProductController::class, 'Index'])->middleware('auth')->middleware('is_admin');

// Store product
Route::post('/admin/products', [ProductController::class, 'Store'])->middleware('auth');

// Show create form
Route::get('/admin/products/create', [ProductController::class, 'Create'])->middleware('auth');

// Show product delete page
Route::get('/admin/products/{product}/delete', [ProductController::class, 'Show'])->middleware('auth');

// Delete product
Route::delete('/admin/products/{product}/delete', [ProductController::class, 'Destroy'])->middleware('auth');

// Edit product
Route::get('/admin/products/{product}/edit', [ProductController::class, 'Edit'])->middleware('auth');

// Update product
Route::put('/admin/products/{product}/edit', [ProductController::class, 'Update'])->middleware('auth');

Route::post('/user/profile/product', [AuthController::class, 'Update']);


// Create product page
Route::get('/user/create_recipe', [RecipeController::class, 'OpenRecipeCreatePage'])->middleware('auth');

// Store products
Route::post('/user/create_recipe', [RecipeController::class, 'SubmitRecipeCreate'])->middleware('auth');

//Show recipes
Route::get('/user/show_recipes', [RecipeController::class, 'OpenRecipeListPage'])->middleware('auth');


// Show recipe
Route::get('/user/show_recipes/{recipe}', [RecipeController::class, 'InitiateSelection'])->middleware('auth');


// show recipe making page
Route::get('/user/start_making/{recipe}', [RecipeController::class, 'StartRecipeCreation'])->middleware('auth');

// post
Route::post('/user/start_making/{recipe}', [RecipeController::class, 'StopRecipe'])->middleware('auth');


// mange_products

Route::get('/user/manage_products/{recipe}', [RecipeController::class, 'LoadRecipeProducts'])->middleware('auth');


//Open cart page
Route::get('/user/cart', [CartController::class, 'OpenUserCartPage'])->middleware('auth');

//Show order page
Route::get('/user/cart/order', [OrderController::class, 'OpenOrderPage'])->middleware('auth');

//Create order
Route::post('/user/cart/order', [OrderController::class, 'SubmitAndValidate'])->middleware('auth');

//Remove product from cart
Route::post('/user/cart/{id}', [CartController::class, 'DeleteProductFromCart'])->middleware('auth');


//Admin order page
Route::get('/admin/orders', [OrderController::class, 'OpenAdminOrderPage'])->middleware('auth')->middleware('is_admin');


//complete order
Route::post('/admin/orders/complete/{order}', [OrderController::class, 'FinishOrder'])->middleware('auth')->middleware('is_admin');


//Cancel order
Route::post('/admin/orders/cancel/{order}', [OrderController::class, 'CancelOrder'])->middleware('auth')->middleware('is_admin');
