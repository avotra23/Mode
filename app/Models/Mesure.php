<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mesure extends Model
{
    protected $fillable = ['user_id', 'libelle', 'donnees'];

    // Cast des données JSON (épaules, poitrine, etc.) en tableau pour manipulation facile
    protected $casts = [
        'donnees' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
