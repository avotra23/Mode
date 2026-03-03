<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\ModeleVetement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class CommandeController extends Controller
{
    public function validation() {
        return view('commande.validation');
    }

    public function store(Request $request) {
        $request->validate([
            'articles' => 'required|array',
            'telephone' => 'required|string',
            'operateur' => 'required|string',
        ]);

        foreach ($request->articles as $article) {
            $modele = ModeleVetement::findOrFail($article['modele_id']);

            Commande::create([
                'user_id'            => auth()->id(),
                'styliste_id'        => $modele->user_id,
                'modele_vetement_id' => $modele->id,
                'taille_choisie'     => $article['taille'],
                'tissu_choisi'       => $article['tissu'],
                'couleur_choisie'    => 'Originale', // Valeur par défaut car absent du formulaire
                'commentaires_personnalisation' => $article['commentaires'],
                'prix_total'         => $modele->prix_base,
                'statut'             => 'en_attente',
                'date_prevue'        => now()->addDays(14),
                'telephone_paiement' => $request->telephone, // Nécessite la modif migration
                'operateur'          => $request->operateur, // Nécessite la modif migration
            ]);
        }
        
        return redirect()->route('catalogue.index')->with('success', 'Commande validée !');
    }
    public function index(Request $request)
        {
            $search = $request->input('search');

            $commandes = Commande::where('user_id', auth()->id())
                ->with('modele') 
                ->when($search, function ($query, $search) {
                    return $query->whereHas('modele_vetement', function ($q) use ($search) {
                        $q->where('nom', 'like', "%{$search}%");
                    })->orWhere('statut', 'like', "%{$search}%");
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return view('commande.index', compact('commandes', 'search'));
        }

public function destroy(Commande $commande)
    {
        // Sécurité : Vérifier que la commande appartient bien à l'utilisateur
        if ($commande->user_id !== auth()->id()) {
            return back()->with('error', 'Action non autorisée.');
        }

        // Vérifier si elle est encore "en_attente"
        if ($commande->statut !== 'en_attente') {
            return back()->with('error', 'Impossible d\'annuler une commande déjà en cours de traitement.');
        }

        $commande->delete();

        return back()->with('success', 'Commande annulée avec succès.');
    }
}
