<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoginController;



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


Route::get('/login',[LoginController::class,'authenticate']);
Route::get('/category',[CategoryController::class,'getAction']);

Route::get('/home',[HomeController::class, 'index']);

// Route::get('/about',function(){
//     // dd("Login Page");
//     return view('about');



// });
Route::get('/products',[ProductController::class, 'index']);

Route::get('/products/{slog}',[ProductController::class, 'show']);

Route::post('/cart',[CartController::class,'add']);

Route::get('/show',[CartController::class,'showCart']);

