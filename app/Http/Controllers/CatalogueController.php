<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Collection,ModeleVetement};

class CatalogueController extends Controller
{
    public function index(Request $request)
    {
        // 1. Création d'une collection fictive
        $collection = new Collection([
            'id' => 1,
            'nom' => 'Héritage Sahel 2026',
            'annee' => 2026
        ]);

        // 2. Création des modèles avec IDs (autorisés par ton $fillable)
        $modele1 = new ModeleVetement([
            'id' => 1,
            'collection_id' => 1,
            'nom' => 'Boubou Royal Silk',
            'description' => 'Un boubou majestueux en soie avec broderies artisanales faites main.',
            'prix_base' => 85000,
            'images' => ['https://images.unsplash.com/photo-1590736961649-7100b3a82765?q=80&w=800'],
        ]);
        $modele1->setRelation('collection', $collection);

        $modele2 = new ModeleVetement([
            'id' => 2,
            'collection_id' => 1,
            'nom' => 'Veste Saharienne Wax',
            'description' => 'Veste légère en coton wax authentique, idéale pour les sorties urbaines.',
            'prix_base' => 45000,
            'images' => ['https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=800'],
        ]);
        $modele2->setRelation('collection', $collection);

        $modele3 = new ModeleVetement([
            'id' => 3,
            'collection_id' => 1,
            'nom' => 'Robe Kimono Indigo',
            'description' => 'Teinture naturelle indigo, coupe fluide respectant les traditions.',
            'prix_base' => 60000,
            'images' => ['https://images.unsplash.com/photo-1496747611176-843222e1e57c?q=80&w=800'],
        ]);
        $modele3->setRelation('collection', $collection);

        // 3. Regroupement dans une collection Laravel pour la vue
        $modeles = collect([$modele1, $modele2, $modele3]);

        // Logique de recherche
        if ($request->has('search')) {
            $search = strtolower($request->get('search'));
            $modeles = $modeles->filter(function ($item) use ($search) {
                return str_contains(strtolower($item->nom), $search) ||
                    str_contains(strtolower($item->description), $search);
            });
        }

        return view('catalogue.index', compact('modeles'));
    }

    public function show($id)
    {
        // Simulation d'une collection pour le détail
        $collection = new Collection(['nom' => 'Héritage Sahel 2026']);

        // Données dynamiques selon l'ID pour le test
        $noms = [1 => 'Boubou Royal Silk', 2 => 'Veste Saharienne Wax', 3 => 'Robe Kimono Indigo'];
        $prix = [1 => 85000, 2 => 45000, 3 => 60000];
        $images = [
            1 => 'https://images.unsplash.com/photo-1590736961649-7100b3a82765?q=80&w=800',
            2 => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=800',
            3 => 'https://images.unsplash.com/photo-1496747611176-843222e1e57c?q=80&w=800'
        ];

        $modele = new ModeleVetement([
            'id' => $id,
            'nom' => $noms[$id] ?? 'Modèle Inconnu',
            'description' => 'Cette pièce unique est conçue selon vos mesures avec les meilleurs tissus locaux.',
            'prix_base' => $prix[$id] ?? 0,
            'images' => [$images[$id] ?? 'https://via.placeholder.com/800'],
        ]);

        $modele->setRelation('collection', $collection);

        return view('catalogue.show', compact('modele'));
    }
    public function collections()
    {
        // Simulation de plusieurs collections
        $c1 = new Collection(['id' => 1, 'nom' => 'Héritage Sahel 2026', 'annee' => 2026]);
        $c2 = new Collection(['id' => 2, 'nom' => 'Urban Wax 2025', 'annee' => 2025]);
        $c3 = new Collection(['id' => 3, 'nom' => 'Indigo Spirit', 'annee' => 2025]);

        $collections = collect([$c1, $c2, $c3]);

        return view('catalogue.collection', compact('collections'));
    }
}
