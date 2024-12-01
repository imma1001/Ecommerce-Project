<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Post_replyController;

Route::get('/contact', [Post_replyController::class, 'index'])->name('site.contact');
Route::post('/contact/posts', [Post_replyController::class, 'store'])->name('posts.store');
Route::post('/contact/replies', [Post_replyController::class, 'storeReply'])->name('replies.store');

// Route to show the customer information form
//Route::get('/checkout/customer', [PaymentController::class, 'showCustomerForm'])->name('checkout.customer');
/// Route to handle the form submission for customer information
//Route::post('/checkout/customer', [PaymentController::class, 'storeCustomerInfo'])->name('storeCustomerInfo');
Route::get('/checkout', [PaymentController::class, 'showCheckoutForm'])->name('checkout.form');
Route::post('/payment', [PaymentController::class, 'processPayment'])->name('payment.process');


Route::get('/user/profile', [AppController::class, 'welcome'])->name(name:'site.index');
Route::get('/productDetails/{id}', [AppController::class, 'details'])->name(name:'products.details');
Route::get('/productsPage/{CatId?}', [AppController::class, 'productsCatId'])->name(name:'products.byCategory');
Route::get('/about', [AppController::class, 'about'])->name(name:'site.about');
//Route::get('/contact', [AppController::class, 'contact'])->name(name:'site.contact');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
Route::get('/redirect', [AppController::class, 'redirect'])->name(name:'redirect');


//Cart
Route::get('/cart', [CartController::class, 'showCartProducts'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'AddtoCart'])->name('cart.add');
Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');




//Admin
Route::get('/category', [AdminController::class, 'Admin_category']);
Route::post('/store_category', [AdminController::class, 'store']);
Route::get('/category',[AdminController::class, 'show']);
Route::delete('/category/{id}',[AdminController::class, 'destroy'])->name(name:'category.destroy');


Route::get('/orders', [OrderController::class, 'index']);
Route::get('/cash', [OrderController::class, 'Cash_order'])->name('cash.orders');
Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
// routes/web.php

Route::get('/send-order-email/{orderId}', [OrderController::class, 'sendOrderEmail'])->name('send.order.email');


Route::post('/credit-order', [OrderController::class, 'createCreditCardOrder'])->name('credit.order.create');
Route::get('/orders/{id}/download',  [OrderController::class, 'downloadOrderDetails'])->name('order.download');



Route::get('/products', [AdminController::class, 'adminProduct'])->name('prod.admin'); // List products
Route::get('/products/create', [AdminController::class, 'create'])->name('prod.create'); // Create product
Route::post('/products', [AdminController::class, 'storeP'])->name('prod.store'); // Store product
Route::get('/products/{id}/edit', [AdminController::class, 'edit'])->name('prod.edit'); // Edit product
Route::put('/products/{id}', [AdminController::class, 'update'])->name('prod.update'); // Update product
Route::delete('/products/{id}', [AdminController::class, 'destroyP'])->name('prod.destroy'); // Delete product






