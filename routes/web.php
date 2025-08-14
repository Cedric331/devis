<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\QuoteController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('clients', [ClientController::class, 'index'])->middleware('permission:clients.read');
    Route::post('clients', [ClientController::class, 'store'])->middleware('permission:clients.create');
    Route::delete('clients/{client}', [ClientController::class, 'destroy'])->middleware('permission:clients.delete');

    Route::get('quotes', [QuoteController::class, 'index'])->middleware('permission:quotes.read');
    Route::post('quotes', [QuoteController::class, 'store'])->middleware('permission:quotes.create');
    Route::delete('quotes/{quote}', [QuoteController::class, 'destroy'])->middleware('permission:quotes.delete');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
