<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DeckBuilderController;
use App\Http\Controllers\UserDeckController;

/*
|--------------------------------------------------------------------------
| Rotte pubbliche (homepage + autenticazione)
|--------------------------------------------------------------------------
*/

// Homepage pubblica (lista dei deck pubblici)
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return redirect()->route('home'); // o 'deck.builder'
})->name('dashboard');
/*
|--------------------------------------------------------------------------
| Rotte di autenticazione (aggiunte da Breeze)
|--------------------------------------------------------------------------
|
| Queste rotte sono create da Breeze automaticamente:
| - login
| - register
| - forgot-password
| - reset-password
| - email verification (se attivata)
| - logout
|
*/

require __DIR__.'/auth.php';



/*
|--------------------------------------------------------------------------
| Rotte protette (solo utenti loggati)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Pagina "Crea deck" → collegamento al tuo Deck Builder Livewire
   Route::get('/deck-builder', function () {
        return view('deck-builder-page');
    })->name('deck.builder');

    // I miei deck
    Route::get('/my-decks', [UserDeckController::class, 'index'])
        ->name('my.decks');

    // Deck preferiti (placeholder per ora)
    Route::get('/favorites', function () {
        return 'Pagina preferiti (in costruzione)';
    })->name('favorites');
});