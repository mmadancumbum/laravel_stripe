<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PaymentController;

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
    return view('welcome');
});

Auth::routes();


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware("auth")->group(function () 
{
    Route::get('/payment/{string}/{price}', [PaymentController::class, 'charge'])->name('goToPayment');
    Route::post('payment/process-payment/{string}/{price}', [PaymentController::class, 'processPayment'])->name('processPayment');
});


    


