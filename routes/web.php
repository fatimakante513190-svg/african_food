<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use App\Models\Order;

// Page d'accueil (carte)
Route::get('/', [MenuController::class, 'index'])->name('home');

// Routes pour tout le monde (connecté ou pas)
Route::middleware('auth')->group(function () {
    // Commandes client
    Route::post('/commander', [OrderController::class, 'store'])->name('order.store');
    Route::get('/mes-commandes', [OrderController::class, 'history'])->name('order.history');
    
    // Gestion des commandes (admin + serveur)
    Route::get('/staff/commandes', [OrderController::class, 'staffIndex'])->name('staff.orders');
    Route::put('/staff/commande/{id}/status', [OrderController::class, 'updateStatus'])->name('staff.update-status');
    
    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes admin UNIQUEMENT (gestion des produits)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', ProductController::class);
});

require __DIR__.'/auth.php';

Route::get('/api/pending-count', function () {
    if (!auth()->check()) return 0;
    if (!auth()->user()->isAdmin() && !auth()->user()->isServeur()) return 0;
    
    return response()->json([
        'count' => Order::where('status', 'en_attente')->count()
    ]);
})->name('api.pending-count');