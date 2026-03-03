<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\StylisteController;
// ... (tes autres imports)

// --- PUBLIC ---
Route::get('/', [CatalogueController::class, 'index'])->name('catalogue.index');
Route::get('/article/{id}', [CatalogueController::class, 'show'])->name('catalogue.show');
Route::get('/collections', [CatalogueController::class, 'collections'])->name('collections.index');

// --- AUTH / INSCRIPTION ---
Route::get('/inscription', [RegisterController::class, 'show'])->name('inscription');
Route::post('/inscription', [RegisterController::class, 'register'])->name('inscription.store');

// --- ESPACE CONNECTÉ ---
Route::middleware(['auth'])->group(function () {

    // Client
    Route::get('/commande/validation', [CommandeController::class, 'validation'])->name('commande.validation');
    Route::post('/commande/store', [CommandeController::class, 'store'])->name('commande.store');
    Route::get('/commandes', [CommandeController::class, 'index'])->name('commandes.index');
    Route::delete('/commandes/{commande}', [CommandeController::class, 'destroy'])->name('commandes.destroy');
    // ESPACE STYLISTE
    Route::prefix('styliste')->name('styliste.')->group(function () {
        Route::get('/dashboard', [StylisteController::class, 'dashboard'])->name('dashboard');

        // COLLECTIONS (On utilise vos noms de méthodes personnalisés)
        Route::get('/collections/create', [StylisteController::class, 'createCollection'])->name('collections.create');
        Route::post('/collections/store', [StylisteController::class, 'storeCollection'])->name('collections.store');
        Route::get('/collections/{id}/edit', [StylisteController::class, 'editCollection'])->name('collections.edit');
        Route::put('/collections/{id}', [StylisteController::class, 'updateCollection'])->name('collections.update');
        Route::delete('/collections/{id}', [StylisteController::class, 'destroyCollection'])->name('collections.destroy');

        // MODÈLES
        Route::get('/modeles/create', [StylisteController::class, 'createModele'])->name('modeles.create');
        Route::post('/modeles/store', [StylisteController::class, 'storeModele'])->name('modeles.store');
        Route::get('/modeles/{id}', [StylisteController::class, 'showModele'])->name('modeles.show');
        Route::get('/modeles/{id}/edit', [StylisteController::class, 'editModele'])->name('modeles.edit');
        Route::put('/modeles/{id}', [StylisteController::class, 'updateModele'])->name('modeles.update');
        Route::delete('/modeles/{id}', [StylisteController::class, 'destroyModele'])->name('modeles.destroy');
    });
});

require __DIR__.'/auth.php';
