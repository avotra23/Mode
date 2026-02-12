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
            'telephone' => 'required',
            'operateur' => 'required',
        ]);

        foreach ($request->articles as $article) {
            // Récupération du prix original du modèle
            $modele = ModeleVetement::find($article['modele_id']);

            Commande::create([
                'user_id'                       => Auth::id(),
                'styliste_id'                   => $modele->user_id, // Créateur du vêtement
                'modele_vetement_id'            => $article['modele_id'],
                'taille_choisie'                => $article['taille'],
                'tissu_choisi'                  => $article['tissu'],
                'couleur_choisie'               => $article['couleur'] ?? 'Originale',
                'commentaires_personnalisation' => $article['commentaires'],
                'prix_total'                    => $modele->prix,
                'statut'                        => 'en_attente',
                'date_prevue'                   => now()->addDays(14), // 2 semaines de confection
                'telephone_paiement'            => $request->telephone, // Champ à ajouter ou gérer à part
                'operateur'                     => $request->operateur,
            ]);
        }

        return redirect()->route('catalogue.index')->with('success', 'Commande envoyée avec succès !');
    }
}
