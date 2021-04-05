<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
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


Route::middleware(['auth', 'role:administrator'])->group(function (){
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });

});

require __DIR__.'/auth.php';
