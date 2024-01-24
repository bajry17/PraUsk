<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return view('Auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('wallet', WalletController::class);
Route::resource('product', ProductController::class);
Route::resource('transaction', TransactionController::class);
Route::post('addToCart', [TransactionController::class,'AddToCart'])->name('AddToCart');
Route::post('paynow', [TransactionController::class,'paynow'])->name('paynow');
Route::put('accept', [TransactionController::class,'accept'])->name('accept');
Route::put('acceptsaldo', [WalletController::class,'acceptsaldo'])->name('acceptsaldo');
Route::put('cancelsaldo', [WalletController::class,'cancelsaldo'])->name('cancelsaldo');
Route::post('topup', [WalletController::class,'topup'])->name('topup');             