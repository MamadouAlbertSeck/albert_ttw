<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;


//Public
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/product/{slug}', [ProductController::class,'show'])->name('product.show'); 

//Cart
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add'); 
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');

//Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index'); 
Route::post('/checkout',[CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

//Webhook
Route::post('/webhook/payment', [PaymentController::class, 'webhook'])->name('payment.webhook');


require __DIR__.'/auth.php';
