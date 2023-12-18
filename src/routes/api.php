<?php

use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentStatusController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\ApiToken;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/payments', [PaymentController::class, 'index'])
    ->name('payments.index');
Route::get('/payments/{payment}', [PaymentController::class, 'show'])
    ->name('payments.show');

Route::middleware([ApiToken::class])->group(function () {
    Route::post('/payments', [PaymentController::class, 'store'])
        ->name('payments.store');
    Route::post('/payments/{payment}/toggleStatus', [PaymentStatusController::class, 'toggle'])
        ->name('payment_statuses.index');
    Route::delete('/payments/{payment}', [PaymentController::class, 'destroy'])
        ->name('payments.destroy');

    Route::get('/users', [UserController::class, 'index'])
        ->name('users.index');
});

Route::get('/statuses', [PaymentStatusController::class, 'index'])
    ->name('payment_statuses.index');

Route::get('/currencies', [CurrencyController::class, 'index'])
    ->name('currencies.index');

