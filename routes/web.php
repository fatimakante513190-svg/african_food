<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/commander', [App\Http\Controllers\OrderController::class, 'store'])->name('order.store');
    Route::get('/mes-commandes', [App\Http\Controllers\OrderController::class, 'history'])->name('order.history');

    // Routes staff (accessible à tous les connectés pour débuter)
    Route::get('/staff/commandes', [App\Http\Controllers\OrderController::class, 'staffIndex'])->name('staff.orders');
    Route::put('/staff/commande/{id}/status', [App\Http\Controllers\OrderController::class, 'updateStatus'])->name('staff.update-status');
});


require __DIR__.'/auth.php';
