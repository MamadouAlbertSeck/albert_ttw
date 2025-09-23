<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;

use App\Http\Controllers\Admin\AuthController as AdminAuth;
use App\Http\Controllers\Admin\ProductController as AdminProduct;
use App\Http\Controllers\Admin\OrderController as AdminOrder;




//Public
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/product/{slug}', [ProductController::class,'show'])->name('product.show'); 

//Cart
// Ajouter au panier
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add'); 

// Afficher le panier
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

// Mettre à jour les quantités
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');

// Supprimer un produit
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

//Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index'); 
Route::post('/checkout',[CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

//Webhook
Route::post('/webhook/payment', [PaymentController::class, 'webhook'])->name('payment.webhook');

//Admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminAuth::class, 'showLoginForm'])->name('login');
    Route::post('login', [AdminAuth::class, 'login']);
    Route::post('logout', [AdminAuth::class, 'logout'])->name('logout');

    Route::middleware('auth:admin')->group(function () {
        Route::get('/', fn() => view('admin.dashboard'))-> name('dashboard');
        
        Route::resource('products', AdminProduct::class);
        Route::get('orders', [AdminOrder::class, 'index'])->name('orders.index');
        Route::patch('orders/{order}/status', [AdminOrder::class, 'updateStatus'])->name('orders.updateStatus');
    } );
});


require __DIR__.'/auth.php';
