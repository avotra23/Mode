<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = ['type', 'valeur', 'surcout'];

    // Récupérer tous les modèles qui utilisent cette option
    public function modeles()
    {
        return $this->belongsToMany(ModeleVetement::class, 'modele_option');
    }
}
