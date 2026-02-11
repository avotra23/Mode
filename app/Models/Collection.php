<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $fillable = ['nom', 'saison', 'annee', 'description', 'est_active'];

    // Une collection possède plusieurs modèles de vêtements
    public function modeles()
    {
        return $this->hasMany(ModeleVetement::class);
    }
}
