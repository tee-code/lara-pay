<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaystackController;
use Illuminate\Support\Facades\Route;



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
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/pay', [PaymentController::class, 'index'])->name('payment');
Route::get('/success/{ref?}', [PaymentController::class, 'success'])->defaults('ref', null)->name('success');
Route::get('/cancel/{ref?}', [PaymentController::class, 'cancel'])->defaults('ref', null)->name('cancel');

Route::post('/pay', [PaymentController::class, 'redirectToGateway'])->name('pay');

Route::get('/redirect', [PaystackController::class, 'redirect'])->name('paystack.redirect');
Route::get('/payment/callback', [PaystackController::class, 'verify'])->name('paystack.verify');

require __DIR__ . '/auth.php';