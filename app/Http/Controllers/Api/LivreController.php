<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Livre;
use Illuminate\Http\Request;

class LivreController extends Controller
{
   // Liste de base (ou filtres simples)
    public function index()
    {
        $livres = Livre::with(['category', 'exemplaires'])->get();
        return response()->json(['success' => true, 'data' => $livres]);
    }

    // Recherche par Titre
    public function searchByTitle(Request $request)
    {
        $search = $request->query('q'); // ex: /api/livres/search?q=compost
        $livres = Livre::with(['category', 'exemplaires'])
                    ->where('titre', 'like', "%$search%")
                    ->get();

        return response()->json(['success' => true, 'data' => $livres]);
    }

    // Filtrer par Catégorie
    public function filterByCategory($categoryName)
    {
        $livres = Livre::with(['category', 'exemplaires'])
                    ->whereHas('category', function ($q) use ($categoryName) {
                        $q->where('nom', 'like', "%$categoryName%");
                    })->get();

        return response()->json(['success' => true, 'category' => $categoryName, 'data' => $livres]);
    }

    // Livres Populaires et Nouveautés
    public function getTrends(Request $request)
    {
        $query = Livre::with(['category', 'exemplaires']);

        if ($request->has('popular')) {
            $query->orderBy('vues', 'desc');
        } elseif ($request->has('new')) {
            $query->latest();
        }

        return response()->json(['success' => true, 'data' => $query->limit(10)->get()]);
    }
}
