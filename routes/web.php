<?php

use App\Models\Sales;
use App\Mail\UserTransaction;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SlidersController;
use App\Http\Controllers\AdminFaqController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\AdminTagsController;
use App\Http\Controllers\HoroscopeController;
use App\Http\Controllers\AdminSalesController;
use App\Http\Controllers\SocialLoginController;
use App\Http\Controllers\AdminArticleController;
use App\Http\Controllers\AdminPaymentController;
use App\Http\Controllers\AdminDiscountController;
use App\Http\Controllers\AdminProductsController;
use App\Http\Controllers\AdminTrackingController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminPaymentMethodsController;
use App\Http\Controllers\AdminProductOptionsController;

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
Route::post('/newsletter', [IndexController::class, 'store'])->name('newsletter');

Route::get('/articles', [IndexController::class, 'index'])->name('articles');
Route::get('/article-detail/{slug}', [ArticleController::class, 'show'])->name('article-detail');

Route::get('/product/{slug}', [ProductsController::class, 'productDetail'])->name('product-detail');
Route::post('/get-sku', [ProductsController::class, 'getSku'])->name('get-sku');

Route::get('/contact-us', [ContactController::class, 'index'])->name('contact-us');
Route::get('/contact-us', [ContactController::class, 'index'])->name('contact-us');

Route::get('/horoscope', [HoroscopeController::class, 'index'])->name('horoscope.index');
Route::get('/horoscope/places', [HoroscopeController::class, 'places'])->name('horoscope.places');
Route::post('/horoscope/natal', [HoroscopeController::class, 'natal'])->name('horoscope.natal');
  
Route::get('auth/google', [SocialLoginController::class, 'redirectToGoogle'])->name('google');
Route::get('google/callback', [SocialLoginController::class, 'handleGoogleCallback'])->name('google.callback');
// Route::get('/product', function(){
//     return view ('product-detail');
// });

// Route::get('/cart', function(){
//     return view ('cart');
// });

Route::get('mail', function(){
    $sales = Sales::where('sales_no', '1630512377')->firstOrFail();
    return view('emails.admin-notification', compact('sales'));
});

Route::get('/faq', [AdminFaqController::class, 'display'])->name('faq');

Route::get('/tag/{id}', [AdminTagsController::class, 'show'])->name('tag.show');

Route::get('send-mail', function () {
    $sales = Sales::where('sales_no', '1630512377')->firstOrFail();
    Mail::send(new UserTransaction($sales));
   
    dd("Email is Sent.");
});

Route::middleware(['auth'])->group(function(){
    Route::get('/account', [UserController::class, 'account'])->name('user.account');
    Route::get('/account/edit', [UserController::class, 'accountEdit'])->name('user.account-edit');
    Route::post('/account/update', [UserController::class, 'accountUpdate'])->name('user.account-update');
    Route::get('/orders', [UserController::class, 'orders'])->name('user.orders');
    Route::get('/confirm-payment/{id}', [UserController::class, 'confirmPayment'])->name('user.confirm-payment');
    Route::post('/confirm-payment/submit/{id}', [UserController::class, 'confirmSubmit'])->name('user.confirm-submit');

    Route::post('/address/add-checkout', [AddressController::class, 'addCheckout'])->name('address.add-checkout');
    Route::get('/address/update-address', [AddressController::class, 'updateAddress'])->name('address.update-address');
    
    Route::get('/checkout', [SalesController::class, 'checkout'])->name('sales.checkout');
    Route::get('/checkout/{id}/detail', [SalesController::class, 'detail'])->name('sales.detail');
    Route::post('/checkout/{id}/question/add', [SalesController::class, 'addQuestion'])->name('sales.question');
    Route::get('/checkout/{id}/shipping', [SalesController::class, 'shipping'])->name('sales.shipping');
    Route::get('/checkout/findCityShipping', [SalesController::class, 'findCityShipping'])->name('sales.findCityShipping');
    Route::get('/checkout/checkShippingCost', [SalesController::class, 'checkShippingCost'])->name('sales.checkShippingCost');
    Route::post('/checkout/{id}/shipping/add', [SalesController::class, 'addShipping'])->name('sales.addShipping');
    Route::get('/checkout/{id}/summary', [SalesController::class, 'summary'])->name('sales.summary');
    Route::post('/checkout/{id}/discount', [SalesController::class, 'discount'])->name('sales.discount');
    Route::get('/checkout/{id}/payment', [SalesController::class, 'paymentMethods'])->name('sales.paymentmethods');
    Route::get('/checkout/{id}/confirm-payment', [SalesController::class, 'confirmPayment'])->name('sales.confirm-payment');
    Route::post('/checkout/{id}/confirm-payment/submit', [SalesController::class, 'submitPayment'])->name('sales.submit-payment');
    Route::get('/checkout/{id}/payment-success', [SalesController::class, 'success'])->name('sales.success');
});

// Route::get('/checkout/detail', function(){
//     return view ('checkout.detail');
// });

// Route::get('/checkout/summary', function(){
//     return view ('checkout.summary');
// });

// Route::get('/checkout/payment', function(){
//     return view ('checkout.payment');
// });

// Route::get('/checkout/confirm-payment', function(){
//     return view ('checkout.confirm-payment');
// });

Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
Route::get('/cart/min/{id}', [CartController::class, 'min'])->name('cart.min');
Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.plus');
Route::get('/cart/plus/{id}', [CartController::class, 'plus'])->name('cart.plus');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

Route::middleware(['auth', 'role:administrator'])->group(function (){
    Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::post('/upload/image', [AdminArticleController::class, 'upload'])->name('admin.upload.image');

    Route::get('/admin/articles', [AdminArticleController::class, 'index'])->name('admin.articles');
    Route::post('/admin/articles/store', [AdminArticleController::class, 'store'])->name('admin.articles.store');
    Route::get('/admin/articles/edit/{id}', [AdminArticleController::class, 'edit'])->name('admin.articles.edit');
    Route::post('/admin/articles/update', [AdminArticleController::class, 'update'])->name('admin.articles.update');
    Route::get('/admin/articles/delete/{id}', [AdminArticleController::class, 'destroy'])->name('admin.articles.destroy');

    Route::get('/admin/tags', [AdminTagsController::class, 'index'])->name('admin.tags');
    Route::post('/admin/tags/store', [AdminTagsController::class, 'store'])->name('admin.tags.store');
    Route::get('/admin/tags/edit/{id}', [AdminTagsController::class, 'edit'])->name('admin.tags.edit');
    Route::post('/admin/tags/update', [AdminTagsController::class, 'update'])->name('admin.tags.update');
    Route::get('/admin/tags/delete/{id}', [AdminTagsController::class, 'destroy'])->name('admin.tags.destroy');

    Route::get('/admin/products', [AdminProductsController::class, 'index'])->name('admin.products');
    Route::post('/admin/products/store', [AdminProductsController::class, 'store'])->name('admin.products.store');
    Route::get('/admin/products/edit/{id}', [AdminProductsController::class, 'edit'])->name('admin.products.edit');
    Route::post('/admin/products/update', [AdminProductsController::class, 'update'])->name('admin.products.update');
    Route::get('/admin/products/delete/{id}', [AdminProductsController::class, 'destroy'])->name('admin.products.destroy');
    Route::get('/admin/products/generate-sku', [AdminProductsController::class, 'generateSKU'])->name('admin.products.generate-sku');
    
    Route::get('/admin/products/{id}/variant', [AdminProductOptionsController::class, 'index'])->name('admin.product-options');
    Route::post('/admin/product-variants/store', [AdminProductOptionsController::class, 'store'])->name('admin.product-options.store');
    Route::post('/admin/product-variants/store-sku', [AdminProductOptionsController::class, 'storeSKU'])->name('admin.product-options.store-sku');
    Route::get('/admin/product-variant/{id}/edit', [AdminProductOptionsController::class, 'editVariant'])->name('admin.product-options.edit-variant');
    Route::post('/admin/product-variants/update', [AdminProductOptionsController::class, 'updateVariant'])->name('admin.product-options.update-variant');
    Route::get('/admin/product-variant/value/{id}/delete', [AdminProductOptionsController::class, 'deleteVariantValue'])->name('admin.product-options.delete-variantval');
    Route::get('/admin/product-variant/{id}/delete', [AdminProductOptionsController::class, 'deleteVariant'])->name('admin.product-options.delete-variant');
    Route::get('/admin/product-variant/sku/{id}/edit', [AdminProductOptionsController::class, 'editSKU'])->name('admin.product-options.edit-sku');
    Route::post('/admin/product-variants/update-sku', [AdminProductOptionsController::class, 'updateSKU'])->name('admin.product-options.update-sku');
    Route::get('/admin/product-variant/sku/{id}/delete', [AdminProductOptionsController::class, 'deleteSKU'])->name('admin.product-options.delete-sku');
    
    Route::get('/admin/payment-methods', [AdminPaymentMethodsController::class, 'index'])->name('admin.paymentMethods');
    Route::post('/admin/payment-methods/store', [AdminPaymentMethodsController::class, 'store'])->name('admin.paymentMethods.store');
    Route::get('/admin/payment-methods/edit/{id}', [AdminPaymentMethodsController::class, 'edit'])->name('admin.paymentMethods.edit');
    Route::post('/admin/payment-methods/update', [AdminPaymentMethodsController::class, 'update'])->name('admin.paymentMethods.update');
    Route::get('/admin/payment-methods/delete/{id}', [AdminPaymentMethodsController::class, 'destroy'])->name('admin.paymentMethods.destroy');

    Route::get('/admin/faq', [AdminFaqController::class, 'index'])->name('admin.faq');
    Route::get('/admin/faq/edit/{id}', [AdminFaqController::class, 'edit'])->name('admin.faq.edit');
    Route::post('/admin/faq/update', [AdminFaqController::class, 'update'])->name('admin.faq.update');
    Route::post('/admin/faq/store', [AdminFaqController::class, 'store'])->name('admin.faq.store');
    Route::get('/admin/faq/delete/{id}', [AdminFaqController::class, 'destroy'])->name('admin.faq.destroy');

    Route::get('/admin/sliders', [SlidersController::class, 'index'])->name('admin.sliders');
    Route::get('/admin/sliders/edit/{id}', [SlidersController::class, 'edit'])->name('admin.sliders.edit');
    Route::post('/admin/sliders/update', [SlidersController::class, 'update'])->name('admin.sliders.update');
    Route::post('/admin/sliders/store', [SlidersController::class, 'store'])->name('admin.sliders.store');
    Route::get('/admin/sliders/delete/{id}', [SlidersController::class, 'destroy'])->name('admin.sliders.destroy');

    Route::get('/admin/sales', [AdminSalesController::class, 'index'])->name('admin.sales');
    Route::get('/admin/sales/{id}', [AdminSalesController::class, 'detail'])->name('admin.sales.detail');
    Route::get('/admin/sales/edit/{id}', [AdminSalesController::class, 'edit'])->name('admin.sales.edit');
    Route::post('/admin/sales/update', [AdminSalesController::class, 'update'])->name('admin.sales.update');
    Route::get('/admin/sales/delete/{id}', [AdminSalesController::class, 'destroy'])->name('admin.sales.destroy');

    Route::get('/admin/confirm-payment', [AdminPaymentController::class, 'index'])->name('admin.confirm-payment');
    Route::get('/admin/confirm-payment/{id}/confirm', [AdminPaymentController::class, 'confirm'])->name('admin.confirm-payment.confirm');

    Route::get('/admin/shipping', [AdminTrackingController::class, 'index'])->name('admin.tracking');
    Route::get('/admin/shipping/update/{id}', [AdminTrackingController::class, 'update'])->name('admin.tracking.update');


    Route::get('/admin/discount', [AdminDiscountController::class, 'index'])->name('admin.discount');
    Route::get('/admin/discount/edit/{id}', [AdminDiscountController::class, 'edit'])->name('admin.discount.edit');
    Route::post('/admin/discount/update', [AdminDiscountController::class, 'update'])->name('admin.discount.update');
    Route::post('/admin/discount/store', [AdminDiscountController::class, 'store'])->name('admin.discount.store');
    Route::get('/admin/discount/delete/{id}', [AdminDiscountController::class, 'destroy'])->name('admin.discount.destroy');
});

require __DIR__.'/auth.php';
