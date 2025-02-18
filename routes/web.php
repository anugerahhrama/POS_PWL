<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UserController;
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

Route::get('/', [HomeController::class, 'index']);

Route::prefix('products')->controller(ProductsController::class)->group(function(){
    Route::get('food-beverage', 'food_beverage');
    Route::get('beauty-health', 'beauty_health');
    Route::get('home-care', 'home_care');
    Route::get('baby-kid', 'baby_kid');
});

Route::get('/user/{id}/name/{name}', [UserController::class, 'index']);

Route::get('/penjualan', [PenjualanController::class, 'index']);
