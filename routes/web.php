<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController\CartController;
use App\Http\Controllers\ClientController\CheckoutController;
use App\Http\Controllers\ClientController\ClientContactController;
use App\Http\Controllers\ClientController\HomeController;
use App\Http\Controllers\ClientController\ListProductController;
use App\Http\Controllers\ContactController;

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\productVariantController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;
// Route::get('/', function () {
//     return view('client.index');
// })->name('home');
Route::prefix('/',)->name('client.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('/ListProducts', [ListProductController::class, 'index'])->name('ListProducts');
    Route::get('/{id}/showProduct', [ListProductController::class, 'showProduct'])->name('showProduct');
    Route::post('/review', [ListProductController::class, 'reviewsStore'])->middleware('auth')->name('reviewsStore');
    Route::get('/contact', [ClientContactController::class, 'index'])->name('contact');
    Route::post('/send-contact', [ClientContactController::class, 'sendContact'])->middleware('auth')->name('sendContact');
    //giỏ hàng
    Route::post('/addToCart', [CartController::class, 'addToCart'])->middleware('auth')->name('addToCart');
    Route::get('/cart', [CartController::class, 'cartView'])->middleware('auth')->name('cartView');
    Route::post('/update-cart-quantity', [CartController::class, 'updateCartQuantity'])->name('updateCartQuantity');
    Route::post('/remove-from-cart', [CartController::class, 'removeFromCart'])->name('removeFromCart');
    Route::post('/clear-cart', [CartController::class, 'clearCart'])->name('clearCart');
    //check out
    Route::post('/checkoutOrder', [CheckoutController::class, 'index'])->middleware('auth')->name('checkout');
    Route::get('/fromcheckout', [CheckoutController::class, 'showForm'])->middleware('auth')->name('checkout.showForm');
    Route::post('/checkout', [CheckoutController::class, 'store'])->middleware('auth')->name('checkoutStore');
    Route::get('/checkout/vnpay/callback', [CheckoutController::class, 'vnpayCallback'])->name('checkout.vnpay.callback');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
});
Route::prefix('/admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/' , [ProductController::class, 'dashboard'])->name('dashboard');

    Route::prefix('/products')->name('products.')->group(function () {
        Route::get('/' , [ProductController::class, 'index'])->name('index');
        Route::get('/{id}/show', [ProductController::class, 'show'])->name('show');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/store', [ProductController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ProductController::class,'edit'])->name('edit');
        Route::put('/{id}/update', [ProductController::class,'update'])->name('update');
        Route::delete('/{id}/destroy', [ProductController::class,'destroy'])->name('destroy');
        Route::get('/trashed', [ProductController::class, 'trashed'])->name('trashed');
        Route::patch('/restore/{id}', [ProductController::class, 'restore'])->name('restore');
        Route::delete('/force-delete/{id}', [ProductController::class, 'forceDelete'])->name('forceDelete');
        Route::get('/variants/{id}', [productVariantController::class, 'index'])->name('variants');
        Route::get('/variantsCreate/{id}', [productVariantController::class, 'create'])->name('variants.create');
        Route::post('/variantsStore/{id}', [productVariantController::class, 'store'])->name('variants.store');
        Route::get('{product}/variants/{variant}/edit', [productVariantController::class, 'edit'])->name('variants.edit');
        Route::post('{product}/vartiants/{variant}/update', [productVariantController::class, 'update'])->name('variants.update');
        Route::delete('/variants/{id}/destroy', [productVariantController::class, 'destroy'])->name('variants.destroy');
    });
    Route::prefix('/categories')->name('categories.')->group(function(){
        Route::get('/',[CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class,'create'])->name('create');
        Route::post('/store', [CategoryController::class,'store'])->name('store');
        Route::get('/{id}/edit', [CategoryController::class,'edit'])->name('edit');
        Route::put('/{id}/update', [CategoryController::class,'update'])->name('update');
        Route::delete('/{id}/destroy', [CategoryController::class,'destroy'])->name('destroy');
        Route::get('/trashed', [CategoryController::class, 'trashed'])->name('trashed');
        Route::patch('/restore/{id}', [CategoryController::class, 'restore'])->name('restore');
        Route::delete('/force-delete/{id}', [CategoryController::class, 'forceDelete'])->name('forceDelete');
    });
    Route::prefix('/customers')->name('customers.')->group(function(){
        Route::get('/',[CustomerController::class, 'index'])->name('index');
        Route::get('/create', [CustomerController::class,'create'])->name('create');
        Route::post('/store', [CustomerController::class,'store'])->name('store');
        Route::get('/{id}/edit', [CustomerController::class,'edit'])->name('edit');
        Route::put('/{id}/update', [CustomerController::class,'update'])->name('update');
        Route::delete('/{id}/destroy', [CustomerController::class,'destroy'])->name('destroy');
        Route::get('/trashed', [CustomerController::class, 'trashed'])->name('trashed');
        Route::patch('/restore/{id}', [CustomerController::class, 'restore'])->name('restore');
        Route::delete('/force-delete/{id}', [CustomerController::class, 'forceDelete'])->name('forceDelete');
    });
    Route::prefix('/banners')->name('banners.')->group(function(){
        Route::get('/',[BannerController::class, 'index'])->name('index');
        Route::get('/create', [BannerController::class,'create'])->name('create');
        Route::post('/store', [BannerController::class,'store'])->name('store');
        Route::get('/{id}/edit', [BannerController::class,'edit'])->name('edit');
        Route::put('/{id}/update', [BannerController::class,'update'])->name('update');
        Route::delete('/{id}/destroy', [BannerController::class,'destroy'])->name('destroy');
        Route::get('/trashed', [BannerController::class, 'trashed'])->name('trashed');
        Route::get('/restore/{id}', [BannerController::class, 'restore'])->name('restore');
        Route::delete('/force-delete/{id}', [BannerController::class, 'forceDelete'])->name('forceDelete');
    });
    Route::prefix('/posts')->name('posts.')->group(function(){
        Route::get('/',[PostController::class, 'index'])->name('index');
        Route::get('/{id}/show', [PostController::class, 'show'])->name('show');
        Route::get('/create', [PostController::class,'create'])->name('create');
        Route::post('/store', [PostController::class,'store'])->name('store');
        Route::get('/{post}/edit', [PostController::class,'edit'])->name('edit');
        Route::put('/{post}/update', [PostController::class,'update'])->name('update');
        Route::delete('/{id}/destroy', [PostController::class,'destroy'])->name('destroy');
        Route::get('/trashed', [PostController::class, 'trashed'])->name('trashed');
        Route::patch('/restore/{id}', [PostController::class, 'restore'])->name('restore');
        Route::delete('/force-delete/{id}', [PostController::class, 'forceDelete'])->name('forceDelete');
    });
    Route::prefix('/contacts')->name('contacts.')->group(function(){
        Route::get('/',[ContactController::class, 'index'])->name('index');
        Route::get('/{id}/show', [ContactController::class, 'show'])->name('show');
        Route::get('/{id}/reply', [ContactController::class, 'reply'])->name('reply');
        Route::post('/{id}/send-reply', [ContactController::class, 'sendReply'])->name('sendReply');
        Route::delete('/{id}/destroy', [ContactController::class,'destroy'])->name('destroy');
        Route::get('/trashed', [ContactController::class, 'trashed'])->name('trashed');
        Route::patch('/restore/{id}', [ContactController::class, 'restore'])->name('restore');
        Route::delete('/force-delete/{id}', [ContactController::class, 'forceDelete'])->name('forceDelete');
    });

    Route::prefix('/reviews')->name('reviews.')->group(function () {
        Route::get('/', [ReviewController::class, 'index'])->name('index');
        Route::get('//{id}/show', [ReviewController::class, 'show'])->name('show');
        Route::get('/edit/{id}', [ReviewController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [ReviewController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [ReviewController::class, 'destroy'])->name('destroy');
        Route::post('/toggle-status/{id}', [ReviewController::class, 'toggleStatus'])->name('toggleStatus');
        Route::get('/trashed', [ReviewController::class, 'trashed'])->name('trashed');
        Route::patch('/restore/{id}', [ReviewController::class, 'restore'])->name('restore');
        Route::delete('/force-delete/{id}', [ReviewController::class, 'forceDelete'])->name('forceDelete');

    });

});
Route::prefix('/auth')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/verify-otp-form', [AuthController::class, 'verifyOtpForm'])->name('verifyOtpForm');
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verifyOtp');
});

