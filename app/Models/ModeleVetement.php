<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModeleVetement extends Model
{
    protected $fillable = ['id','collection_id', 'nom', 'description', 'prix_base', 'images'];

    // Conversion automatique du JSON des images en tableau PHP
    protected $casts = [
        'images' => 'array',
    ];

    // Lien vers la collection parente
    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }

    // Un modèle peut avoir plusieurs options (Plusieurs tissus, plusieurs tailles)
    public function options()
    {
        return $this->belongsToMany(Option::class, 'modele_option');
    }
}
