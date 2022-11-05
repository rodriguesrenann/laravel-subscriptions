<?php

use App\Http\Controllers\SiteController;
use App\Http\Controllers\SubscriptionController;
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

Route::group(['middleware' => 'auth'], function () {
    Route::get('/subscriptions/resume', [SubscriptionController::class, 'resume'])->name('subscriptions.resume');
    Route::get('/subscriptions/cancel', [SubscriptionController::class, 'cancel'])->name('subscriptions.cancel');
    Route::post('/subscriptions/store', [SubscriptionController::class, 'store'])->name('subscriptions.store');
    Route::get('/subscriptions/checkout', [SubscriptionController::class, 'index'])->name('subscriptions.checkout')
        ->middleware(['plan.chosen']);
    Route::get('/subscriptions/premium', [SubscriptionController::class, 'premium'])
        ->name('subscriptions.premium')
        ->middleware(['subscribed']);
    Route::get('/subscriptions/invoices', [SubscriptionController::class, 'invoices'])->name('subscriptions.invoices');
    Route::get('/subscriptions/invoices/{invoice}', [SubscriptionController::class, 'downloadInvoice'])
        ->name('subscriptions.invoices.download');
    Route::get('/subscribe/{planUrl}', [SiteController::class, 'createSession'])->name('plan.choice');
});


Route::get('/', [SiteController::class, 'index'])->name('site.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/auth.php';
