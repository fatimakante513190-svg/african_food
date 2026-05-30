<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MenuController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes admin (protégées par middleware auth + admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', ProductController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/commander', [OrderController::class, 'store'])->name('order.store');
    Route::get('/mes-commandes', [OrderController::class, 'history'])->name('order.history');

    // Routes staff (accessible à tous les connectés pour débuter)
    Route::get('/staff/commandes', [OrderController::class, 'staffIndex'])->name('staff.orders');
    Route::put('/staff/commande/{id}/status', [OrderController::class, 'updateStatus'])->name('staff.update-status');
});

require __DIR__.'/auth.php';