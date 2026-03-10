<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
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
    // tous les livres
    Route::get('/livres', [LivreController::class, 'index']);
    // recherche par son titre
    Route::get('/livres/search', [LivreController::class, 'searchByTitle']);
    // filtre par categorie
    Route::get('/livres/categorie/{name}', [LivreController::class, 'filterByCategory']);
    // livres populaire
    Route::get('/livres/trends', [LivreController::class, 'getTrends']);
});

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    // gestion des categories
    Route::apiResource('categories', CategoryController::class);
    
    // gestion des livres (Ajouter/Modifier/Supprimer)
    Route::post('/livres', [LivreController::class, 'store']);
    Route::put('/livres/{id}', [LivreController::class, 'update']);
    Route::delete('/livres/{id}', [LivreController::class, 'destroy']);

    // stats et etat d'usure
    Route::get('/admin/stats', [LivreController::class, 'getStats']);
});
