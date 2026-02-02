<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Transaction;
use App\Http\Controllers\Product;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/self-service', [Transaction::class, 'selfService'])->name('self_service.index');

Route::get('/admin/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// self-service rute
Route::post('/transactions/self-service', [Transaction::class, 'checkoutSelfService'])->name('transactions.selfServiceCheckout');
Route::get('/transactions/pay/{transaction_code}', [Transaction::class, 'checkoutPay'])->name('transactions.checkoutPay');
Route::post('/transaction/midtrans/callback', [Transaction::class, 'midtransCallback'])->name('transactions.midtransCallback')->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
// Endpoint for browser redirect after payment (Midtrans will redirect with query params)
Route::get('/transaction/midtrans/finish', [Transaction::class, 'finish'])->name('transactions.midtransFinish');
Route::get('/transactions/{transaction_code}/result', [Transaction::class, 'result'])->name('transactions.result');
Route::get('/transactions/{transaction_code}/receipt', [Transaction::class, 'receipt'])->name('transactions.receipt');
Route::get('/transactions/{transaction_code}/receiptProposal', [Transaction::class, 'receiptProposal'])->name('transactions.receiptProposal');
Route::patch('/transactions/checkout-self-service/{id}', [Transaction::class, 'checkoutSelfCash'])->name('transactions.checkoutSelfCash');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth', 'role:cashier')->group(function () {
    Route::get('/transactions', [Transaction::class, 'index'])->name('transactions.index');
    Route::post('/transactions', [Transaction::class, 'checkout'])->name('transactions.checkout');

    // Product management for cashier
    Route::resource('products', ProductController::class)->names('products');
    Route::patch('products/toggleStatus/{id}/', [ProductController::class, 'toggleStatus'])->name('products.toggleStatus');
});

Route::middleware('auth', 'role:admin')->group(function () {
    // Product management for admin
    Route::resource('admin/products', ProductController::class)->names('admin.products');

    // Category management for admin
    Route::resource('admin/categories', CategoryController::class)->names('admin.categories');

    // Sales Report for admin
    Route::get('/admin/reports/sales', [ReportController::class, 'sales'])->name('admin.reports.sales');
    Route::get('/admin/reports/sales/{id}', [ReportController::class, 'salesDetail'])->name('admin.reports.sales-detail');
    Route::get('/admin/reports/sales-export', [ReportController::class, 'salesExport'])->name('admin.reports.sales-export');
});

require __DIR__.'/auth.php';
