<?php

use App\Http\Controllers\BuyerOrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController as ControllersOrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Seller\UsersController;
use App\Http\Controllers\Seller\ProductsController;
use App\Http\Controllers\Seller\CategoriesController;
use App\Http\Controllers\Seller\OrderController;

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

Auth::routes();

// OPEN ROUTE
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/men', [HomeController::class, 'genre'])->name('men');
Route::get('/women', [HomeController::class, 'genre'])->name('women');
Route::get('/sale', [HomeController::class, 'genre'])->name('sale');
Route::get('/search', [HomeController::class, 'genre'])->name('search');
Route::get('/category', [HomeController::class, 'genre'])->name('category');
Route::get('/product/{id}/details', [ProductController::class, 'details'])->name('product.details');


Route::group(['middleware' => 'auth'], function () {


    //ADMIN ROUTE
    Route::group(['middleware' => 'seller'], function () {
        // Users
        Route::get('/seller/users', [UsersController::class, 'index'])->name('seller.users');

        // Category
        Route::get('/seller/categories', [CategoriesController::class, 'index'])->name('seller.categories');
        // Sub Category
        Route::post('/seller/categories/store', [CategoriesController::class, 'store'])->name('seller.categories.store');
        Route::patch('/seller/categories/{id}/update', [CategoriesController::class, 'update'])->name('seller.categories.update');
        Route::delete('/seller/categories/{id}/delete', [CategoriesController::class, 'delete'])->name('seller.categories.delete');

        // Main Category
        Route::post('/seller/main/categories/store', [CategoriesController::class, 'mainCategoryStore'])->name('seller.mainCategories.store');
        Route::patch('/seller/main/categories/{id}/update', [CategoriesController::class, 'mainCategoryUpdate'])->name('seller.mainCategories.update');
        Route::delete('/seller/main/categories/{id}/delete', [CategoriesController::class, 'mainCategoryDelete'])->name('seller.mainCategories.delete');

        // Products
        Route::get('/seller/products', [ProductsController::class, 'index'])->name('seller.products');
        Route::get('/seller/products/add', [ProductsController::class, 'add'])->name('seller.products.add');
        Route::post('/seller/products/store', [ProductsController::class, 'store'])->name('seller.products.store');
        Route::get('/seller/products/{id}/edit', [ProductsController::class, 'edit'])->name('seller.products.edit');
        Route::patch('/seller/products/{id}/update', [ProductsController::class, 'update'])->name('seller.products.update');
        Route::delete('/seller/products/{id}/delete', [ProductsController::class, 'delete'])->name('seller.products.delete');

        // Orders
        Route::get('/seller/orders', [OrderController::class, 'index'])->name('seller.orders');
        Route::patch('/seller/orders/{id}/ship', [OrderController::class, 'ship'])->name('seller.orders.ship');
    });
    // END ADMIN ROUTE

    // AUTH ROUTE

    // Product
    Route::get('/product/{id}/handle', [ProductController::class, 'handleRequest'])->name('product.handle');
    Route::get('/product/{id}/buy/cart', [ProductController::class, 'buyFromCart'])->name('product.buy.cart');

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::delete('/cart/{id}/delete', [CartController::class, 'delete'])->name('cart.delete');

    // Check out
    Route::post('/cart/checkout/multiple', [CheckoutController::class, 'checkoutMulti'])->name('checkout.cart.multiple');
    Route::post('/cart/checkout/{id}', [CheckoutController::class, 'cartcheckout'])->name('checkout.cart');
    Route::post('/checkout/{id}', [CheckoutController::class, 'checkout'])->name('checkout');

    // Order
    Route::get('/order', [BuyerOrderController::class, 'show'])->name('order.show');
});

// END AUTH ROUTE
