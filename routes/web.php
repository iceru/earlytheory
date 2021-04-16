<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\AdminArticleController;
use App\Http\Controllers\AdminTagsController;
use App\Http\Controllers\AdminProductsController;
use App\Http\Controllers\AdminPaymentMethodsController;
use App\Http\Controllers\ArticleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [IndexController::class, 'index'])->name('index');

Route::get('/articles', [ArticleController::class, 'index'])->name('articles');
Route::get('/article-detail', [ArticleController::class, 'show'])->name('article-detail');

Route::get('/product', function(){
    return view ('product-detail');
});

Route::get('/cart', function(){
    return view ('cart');
});

Route::get('/checkout/detail', function(){
    return view ('checkout.detail');
});

Route::get('/checkout/summary', function(){
    return view ('checkout.summary');
});

Route::get('/checkout/payment', function(){
    return view ('checkout.payment');
});

Route::get('/checkout/confirm-payment', function(){
    return view ('checkout.confirm-payment');
});

Route::middleware(['auth', 'role:administrator'])->group(function (){
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });

    Route::get('/admin/articles', [AdminArticleController::class, 'index'])->name('admin.articles');
    Route::post('/admin/articles/store', [AdminArticleController::class, 'store'])->name('admin.articles.store');
    Route::get('/admin/articles/edit/{id}', [AdminArticleController::class, 'edit'])->name('admin.articles.edit');
    Route::post('/admin/articles/update', [AdminArticleController::class, 'update'])->name('admin.articles.update');
    Route::get('/admin/articles/delete/{id}', [AdminArticleController::class, 'destroy'])->name('admin.articles.destroy');
    
    Route::get('/admin/tags', [AdminTagsController::class, 'index'])->name('admin.articles');
    Route::post('/admin/tags/store', [AdminTagsController::class, 'store'])->name('admin.articles.store');
    Route::get('/admin/tags/edit/{id}', [AdminTagsController::class, 'edit'])->name('admin.articles.edit');
    Route::post('/admin/tags/update', [AdminTagsController::class, 'update'])->name('admin.articles.update');
    Route::get('/admin/tags/delete/{id}', [AdminTagsController::class, 'destroy'])->name('admin.articles.destroy');
    
    Route::get('/admin/products', [AdminProductsController::class, 'index'])->name('admin.products');
    Route::post('/admin/products/store', [AdminProductsController::class, 'store'])->name('admin.products.store');
    Route::get('/admin/products/edit/{id}', [AdminProductsController::class, 'edit'])->name('admin.products.edit');
    Route::post('/admin/products/update', [AdminProductsController::class, 'update'])->name('admin.products.update');
    Route::get('/admin/products/delete/{id}', [AdminProductsController::class, 'destroy'])->name('admin.products.destroy');
    
    Route::get('/admin/payment-methods', [AdminPaymentMethodsController::class, 'index'])->name('admin.paymentMethods');
    Route::post('/admin/payment-methods/store', [AdminPaymentMethodsController::class, 'store'])->name('admin.paymentMethods.store');
    Route::get('/admin/payment-methods/edit/{id}', [AdminPaymentMethodsController::class, 'edit'])->name('admin.paymentMethods.edit');
    Route::post('/admin/payment-methods/update', [AdminPaymentMethodsController::class, 'update'])->name('admin.paymentMethods.update');
    Route::get('/admin/payment-methods/delete/{id}', [AdminPaymentMethodsController::class, 'destroy'])->name('admin.paymentMethods.destroy');

});

require __DIR__.'/auth.php';
