<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LivreController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/login', [AuthController::class, 'login']);

Route::post('/register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/livres', [LivreController::class, 'index']);
    // recherche par son titre
    Route::get('/livres/search', [LivreController::class, 'searchByTitle']);

    // Filtre par catégorie (Paramètre dans l'URL)
    Route::get('/livres/categorie/{name}', [LivreController::class, 'filterByCategory']);

    // Tendances (Popularité / Nouveauté)
    Route::get('/livres/trends', [LivreController::class, 'getTrends']);
});
