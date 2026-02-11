<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{CatalogueController,CommandeController};
use App\Http\Controllers\Auth\{RegisterController};
// La liste des modèles
Route::get('/', [CatalogueController::class, 'index'])->name('catalogue.index');

// Le détail d'un modèle (on passe l'ID en paramètre)
Route::get('/article/{id}', [CatalogueController::class, 'show'])->name('catalogue.show');


Route::get('/collections', [CatalogueController::class, 'collections'])->name('collections.index');


//Inscription  Affichage de la page
Route::get('/inscription', [RegisterController::class, 'show'])->name('inscription');
// Traitement du formulaire
Route::post('/inscription', [RegisterController::class, 'register'])->name('inscription.store');



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth'])->group(function () {
    // Afficher la page de personnalisation (taille, tissu, etc.)
    Route::get('/commande/validation', [CommandeController::class, 'validation'])->name('commande.validation');

    // Enregistrer la commande finale en base de données
    Route::post('/commande/store', [CommandeController::class, 'store'])->name('commande.store');
});
require __DIR__.'/auth.php';
