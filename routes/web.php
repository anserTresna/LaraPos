<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProdukControllers;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;

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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');


//Produk Controller
Route::get('/produk', [ProdukControllers::class, 'index'])->name('produk.index');
Route::post('/produk', [ProdukControllers::class, 'store'])->name('produk.store');
Route::put('/produk/{id}', [ProdukControllers::class, 'update'])->name('produk.update');
Route::delete('/produk/{id}', [ProdukControllers::class, 'destroy'])->name('produk.destroy');

//karyawan
Route::middleware('filter.user')->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('pegawai.index');
    Route::post('/user', [UserController::class, 'store'])->name('pegawai.store');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('pegawai.update');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('pegawai.destroy');
});

//cart
Route::get('cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/save', [CartController::class, 'saveTransaction'])->name('cart.saveTransaction');