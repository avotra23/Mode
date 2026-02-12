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
        // On récupère le modèle avec ses photos et ses options (tailles/stocks)
        $modele = ModeleVetement::with(['collection', 'options'])->findOrFail($id);

        return view('catalogue.show', compact('modele'));
    }

    /**
     * Affiche toutes les collections disponibles
     */
    public function collections()
    {
        $collections = Collection::latest()->get();
        return view('catalogue.collections', compact('collections'));
    }
}
