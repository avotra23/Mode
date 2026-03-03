<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ModeleVetement;
use App\Models\User;
class Commande extends Model
{
    protected $fillable = [
    'user_id', 'styliste_id', 'modele_vetement_id',
    'taille_choisie', 'tissu_choisi', 'couleur_choisie',
    'commentaires_personnalisation', 'prix_total',
    'statut', 'date_prevue',
    'telephone_paiement', 'operateur','reponse' // À ajouter ici
    ];

    // Le client qui a passé la commande
    public function client()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Le styliste assigné à la confection
    public function styliste()
    {
        return $this->belongsTo(User::class, 'styliste_id');
    }

    // Le modèle de vêtement commandé
    public function modele()
    {
        return $this->belongsTo(ModeleVetement::class, 'modele_vetement_id');
    }
}
