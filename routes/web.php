<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// Route publique (accessible sans connexion)
Route::get('/', [MenuController::class, 'index'])->name('home');

// Dashboard (protégé par auth simple)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes pour utilisateurs connectés (MAIS PAS ADMIN OBLIGATOIRE)
Route::middleware(['auth'])->group(function () {
    // Commandes client
    Route::post('/commander', [OrderController::class, 'store'])->name('order.store');
    Route::get('/mes-commandes', [OrderController::class, 'history'])->name('order.history');
    
    // Routes staff (accessible à serveur et admin)
    Route::get('/staff/commandes', [OrderController::class, 'staffIndex'])->name('staff.orders');
    Route::put('/staff/commande/{id}/status', [OrderController::class, 'updateStatus'])->name('staff.update-status');
    
    // Profile (déjà existant mais mal placé)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes admin (protégées par auth + middleware admin UNIQUEMENT)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', ProductController::class);
});

require __DIR__.'/auth.php';