@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-6">
    <div class="bg-white border border-gray-100 shadow-sm rounded-xl overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-50 flex justify-between items-center">
            <div>
                <h1 class="text-xl font-semibold text-gray-800 tracking-tight">Nouvelle Création</h1>
                <p class="text-xs text-gray-400 mt-1 uppercase tracking-wider">Atelier / Modèles</p>
            </div>
        </div>

        <form action="{{ route('styliste.modeles.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-10">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-[11px] uppercase tracking-widest text-gray-500 font-bold">Collection d'origine</label>
                        <select name="collection_id" class="w-full border-gray-200 rounded-lg text-sm py-3 focus:ring-0">
                            @foreach($collections as $c)
                                <option value="{{ $c->id }}" {{ $selected_collection == $c->id ? 'selected' : '' }}>{{ $c->nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[11px] uppercase tracking-widest text-gray-500 font-bold">Nom du modèle</label>
                        <input type="text" name="nom" class="w-full border-gray-200 rounded-lg text-sm py-3 focus:ring-0" placeholder="ex: Veste croisée en lin" required>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[11px] uppercase tracking-widest text-gray-500 font-bold">Description du modèle</label>
                        <textarea name="description" rows="3" class="w-full border-gray-200 rounded-lg text-sm p-4 focus:ring-0" placeholder="Détails sur la coupe, les finitions..."></textarea>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[11px] uppercase tracking-widest text-gray-500 font-bold">Prix de vente (FCFA)</label>
                        <input type="number" name="prix_base" class="w-full border-gray-200 rounded-lg text-lg font-bold py-3 focus:ring-0 text-indigo-600" placeholder="0" required>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-gray-50/50 border border-gray-100 p-6 rounded-xl">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-[11px] uppercase tracking-widest text-gray-900 font-bold italic">Inventaire</h3>
                            <button type="button" onclick="addSizeRow()" class="text-[10px] bg-gray-900 text-white px-3 py-1 rounded-md uppercase font-bold hover:bg-black transition">+ Ajouter</button>
                        </div>

                        <div id="size-container" class="space-y-3">
                            <div class="flex gap-2 items-center animate-fadeIn">
                                <input type="text" name="noms_tailles[]" placeholder="Taille" class="flex-1 border-gray-200 rounded-md text-xs py-2" required>
                                <input type="number" name="stocks_tailles[]" placeholder="Qté" class="w-16 border-gray-200 rounded-md text-xs text-center py-2" required>
                                <div class="w-6"></div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[11px] uppercase tracking-widest text-gray-500 font-bold">Photos</label>
                        <input type="file" name="images[]" multiple class="w-full text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-gray-100 file:text-gray-600 file:font-bold hover:file:bg-gray-200">
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between pt-6 border-t border-gray-50">
                <a href="{{ route('styliste.dashboard') }}" class="text-xs text-red-400 font-medium hover:text-gray-600">Annuler</a>
                <button type="submit" class="bg-gray-900 text-white px-10 py-3 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-black transition-all shadow-sm">
                    Enregistrer le modèle
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function addSizeRow() {
    const container = document.getElementById('size-container');
    const row = document.createElement('div');
    row.className = 'flex gap-2 items-center animate-fadeIn';
    row.innerHTML = `
        <input type="text" name="noms_tailles[]" placeholder="Taille" class="flex-1 border-gray-200 rounded-md text-xs py-2" required>
        <input type="number" name="stocks_tailles[]" placeholder="Qté" class="w-16 border-gray-200 rounded-md text-xs text-center py-2" required>
        <button type="button" onclick="this.parentElement.remove()" class="w-6 text-gray-300 hover:text-red-500 transition-colors text-sm">✕</button>
    `;
    container.appendChild(row);
}
</script>
@endsection
