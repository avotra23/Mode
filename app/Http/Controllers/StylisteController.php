<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\ModeleVetement;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StylisteController extends Controller
{
    // --- DASHBOARD ---
    public function dashboard()
    {
        $collections = Collection::where('user_id', Auth::id())
            ->with(['modeles.options']) // Eager load pour les performances
            ->get();
        return view('styliste.dashboard', compact('collections'));
    }

    // --- COLLECTIONS ---
    public function createCollection() { return view('styliste.collections.create'); }

    public function storeCollection(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'saison' => 'required|string',
            'annee' => 'required|integer',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data['image'] = $request->file('image')->store('collections', 'public');
        $data['user_id'] = Auth::id();
        $data['est_active'] = true;

        Collection::create($data);
        return redirect()->route('styliste.dashboard')->with('success', 'Collection créée avec succès !');
    }

    public function editCollection($id)
    {
        $collection = Collection::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('styliste.collections.edit', compact('collection'));
    }

    public function updateCollection(Request $request, $id)
    {
        $collection = Collection::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $data = $request->validate([
            'nom' => 'required|string',
            'saison' => 'required',
            'annee' => 'required|integer',
            'description' => 'nullable'
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($collection->image);
            $data['image'] = $request->file('image')->store('collections', 'public');
        }

        $collection->update($data);
        return redirect()->route('styliste.dashboard')->with('success', 'Collection mise à jour !');
    }

    public function destroyCollection($id)
    {
        $collection = Collection::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        Storage::disk('public')->delete($collection->image);
        $collection->delete();
        return back()->with('success', 'Collection supprimée');
    }

    // --- MODÈLES ---
    public function showModele($id)
    {
        $modele = ModeleVetement::with(['collection', 'options'])->findOrFail($id);
        if($modele->collection->user_id != Auth::id()) abort(403);
        return view('styliste.modeles.show', compact('modele'));
    }

    public function createModele(Request $request)
    {
        $collections = Collection::where('user_id', Auth::id())->get();
        $options = Option::all(); // On récupère toutes les options (tailles, etc.)
        $selected_collection = $request->collection_id;
        return view('styliste.modeles.create', compact('collections', 'options', 'selected_collection'));
    }
    public function storeModele(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'prix_base' => 'required|numeric',
            'collection_id' => 'required',
            'noms_tailles' => 'required|array',
            'stocks_tailles' => 'required|array'
        ]);

        // Gestion des images
        $imagePaths = [];
        if($request->hasFile('images')) {
            foreach($request->file('images') as $file) {
                $imagePaths[] = $file->store('modeles', 'public');
            }
        }

        $modele = ModeleVetement::create([
            'collection_id' => $request->collection_id,
            'nom' => $request->nom,
            'description' => $request->description,
            'prix_base' => $request->prix_base,
            'images' => $imagePaths,
        ]);

        // Association des tailles personnalisées
        $syncData = [];
        foreach ($request->noms_tailles as $key => $nomTaille) {
            if (!empty($nomTaille)) {
                // On crée l'option si elle n'existe pas (ex: "XXL")
                $option = Option::firstOrCreate(
                    ['valeur' => strtoupper(trim($nomTaille))],
                    ['type' => 'taille', 'surcout' => 0]
                );

                // On lie au modèle avec le stock spécifique
                $syncData[$option->id] = ['stock' => $request->stocks_tailles[$key] ?? 0];
            }
        }

        $modele->options()->sync($syncData);

        return redirect()->route('styliste.dashboard')->with('success', 'Modèle ajouté avec succès !');
    }
    public function editModele($id)
    {
        $modele = ModeleVetement::with('options')->findOrFail($id);
        if($modele->collection->user_id != Auth::id()) abort(403);

        $collections = Collection::where('user_id', Auth::id())->get();
        $options = Option::all();

        return view('styliste.modeles.edit', compact('modele', 'collections', 'options'));
    }

    public function updateModele(Request $request, $id)
    {
        $modele = ModeleVetement::findOrFail($id);
        if($modele->collection->user_id != Auth::id()) abort(403);

        $request->validate([
            'nom' => 'required',
            'prix_base' => 'required|numeric',
            'collection_id' => 'required',
            'stocks' => 'array'
        ]);

        if($request->hasFile('images')) {
            foreach($modele->images as $img) Storage::disk('public')->delete($img);
            $imagePaths = [];
            foreach($request->file('images') as $file) {
                $imagePaths[] = $file->store('modeles', 'public');
            }
            $modele->images = $imagePaths;
        }

        $modele->update($request->except('images', 'stocks'));

        // Mise à jour des stocks
        if($request->has('stocks')) {
            $syncData = [];
            foreach($request->stocks as $optionId => $stockValue) {
                $syncData[$optionId] = ['stock' => $stockValue];
            }
            $modele->options()->sync($syncData);
        }

        return redirect()->route('styliste.dashboard')->with('success', 'Modèle mis à jour !');
    }

    public function destroyModele($id)
    {
        $modele = ModeleVetement::findOrFail($id);
        if($modele->collection->user_id == Auth::id()){
            foreach($modele->images as $img) Storage::disk('public')->delete($img);
            $modele->delete();
        }
        return back()->with('success', 'Modèle supprimé');
    }
}
