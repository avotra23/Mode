<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\ModeleVetement;

class CatalogueController extends Controller
{
    public function index(Request $request)
    {
        $query = ModeleVetement::with('collection');

        // On remplace ->get() par ->input() pour suivre les standards Laravel
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('nom', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        $modeles = $query->latest()->get();

        return view('catalogue.index', compact('modeles'));
    }

    /**
     * Affiche les détails d'un modèle spécifique
     */
    public function show($id)
    {
        // 1. Récupérer le modèle principal avec ses relations
        $modele = ModeleVetement::with(['collection', 'options'])->findOrFail($id);

        // 2. Récupérer les modèles similaires
        // On cherche les modèles de la même collection, exclus celui qu'on affiche
        $similaires = ModeleVetement::where('collection_id', $modele->collection_id)
            ->where('id', '!=', $id) // Ne pas s'afficher soi-même
            ->with('collection')     // Charger la collection pour les badges
            ->latest()               // Les plus récents en premier
            ->take(4)                // Limiter à 4 résultats
            ->get();

        // 3. Optionnel : Si la collection contient peu d'articles, 
        // on peut compléter avec d'autres modèles aléatoires
        if ($similaires->count() < 4) {
            $idsAExclure = $similaires->pluck('id')->push($modele->id);
            
            $complements = ModeleVetement::whereNotIn('id', $idsAExclure)
                ->with('collection')
                ->inRandomOrder()
                ->take(4 - $similaires->count())
                ->get();

            $similaires = $similaires->concat($complements);
        }

        return view('catalogue.show', compact('modele', 'similaires'));
    }

    /**
     * Affiche toutes les collections disponibles
     */
    public function collections()
    {
        $collections = Collection::latest()->get();
        return view('catalogue.collection', compact('collections'));
    }
}
