<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Exemplaire;
use App\Models\Livre;
use Illuminate\Http\Request;

class LivreController extends Controller
{
    // list des livres
    public function index()
    {
        $livres = Livre::with(['category', 'exemplaires'])->get();
        return response()->json(['success' => true, 'data' => $livres]);
    }

    // recherche le titre
    public function searchByTitle(Request $request)
    {
        $search = $request->query('q');
        $livres = Livre::with(['category', 'exemplaires'])
            ->where('titre', 'like', "%$search%")
            ->get();

        return response()->json(['success' => true, 'data' => $livres]);
    }

    // filtrer par categorie
    public function filterByCategory($categoryName)
    {
        $livres = Livre::with(['category', 'exemplaires'])
            ->whereHas('category', function ($q) use ($categoryName) {
                $q->where('nom', 'like', "%$categoryName%");
            })->get();

        return response()->json(['success' => true, 'category' => $categoryName, 'data' => $livres]);
    }

    // livres populaires et nouveautés
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
    public function getStats()
    {
        // etat global de la collection
        $etatGlobal = Exemplaire::selectRaw('etat_physique, count(*) as total')
            ->groupBy('etat_physique')
            ->get();

        //compte les livres qui sont en etat degradé
        $livresDegrades = Livre::withCount(['exemplaires as exemplaires_degrades_count' => function ($query) {
            $query->where('etat_physique', 'degradé');
        }])->get();

        //livres les plus consultés
        $plusConsultes = Livre::orderBy('vues', 'desc')->limit(5)->get();

        return response()->json([
            'etat_global' => $etatGlobal,
            'popularite' => $plusConsultes,
            'suivi_usure_par_livre' => $livresDegrades
        ]);
    }
    
}
