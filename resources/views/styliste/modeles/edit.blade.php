@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-12 px-6">
    <div class="bg-white border border-gray-100 shadow-sm rounded-xl overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/30">
            <h1 class="text-xl font-medium text-gray-800 italic">Modifier • {{ $modele->nom }}</h1>
        </div>

        <form action="{{ route('styliste.modeles.update', $modele->id) }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-[11px] uppercase tracking-widest text-gray-500 font-bold">Nom du Modèle</label>
                        <input type="text" name="nom" value="{{ $modele->nom }}" class="w-full border-gray-200 rounded-lg text-sm py-3 focus:ring-0">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[11px] uppercase tracking-widest text-gray-500 font-bold">Description</label>
                        <textarea name="description" rows="4" class="w-full border-gray-200 rounded-lg text-sm p-4 focus:ring-0 leading-relaxed text-gray-600">{{ $modele->description }}</textarea>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[11px] uppercase tracking-widest text-gray-500 font-bold">Prix (FCFA)</label>
                        <input type="number" name="prix_base" value="{{ $modele->prix_base }}" class="w-full border-gray-200 rounded-lg text-xl font-black text-indigo-600 py-3 focus:ring-0">
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="bg-indigo-50/30 border border-indigo-100 p-6 rounded-xl">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-[11px] uppercase tracking-widest text-indigo-900 font-bold">Stocks par taille</h3>
                            <button type="button" onclick="addSizeRow()" class="text-[10px] bg-indigo-600 text-white px-3 py-1 rounded-md uppercase font-bold hover:bg-indigo-700 transition">+ Taille</button>
                        </div>

                        <div id="size-container" class="space-y-3">
                            @foreach($modele->options as $option)
                            <div class="flex gap-2 items-center">
                                <input type="text" name="noms_tailles[]" value="{{ $option->valeur }}" class="flex-1 border-gray-200 rounded-md text-xs py-2 shadow-sm">
                                <input type="number" name="stocks_tailles[]" value="{{ $option->pivot->stock }}" class="w-16 border-gray-200 rounded-md text-xs text-center py-2 shadow-sm">
                                <button type="button" onclick="this.parentElement.remove()" class="w-6 text-red-300 hover:text-red-500 transition-colors">✕</button>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-gray-50">
                <button type="submit" class="w-full bg-gray-900 text-white py-4 rounded-lg text-xs font-bold uppercase tracking-[0.2em] hover:bg-black transition-all">
                    Enregistrer les modifications
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
        <input type="text" name="noms_tailles[]" placeholder="Taille" class="flex-1 border-gray-200 rounded-md text-xs py-2 shadow-sm" required>
        <input type="number" name="stocks_tailles[]" placeholder="Qté" class="w-16 border-gray-200 rounded-md text-xs text-center py-2 shadow-sm" required>
        <button type="button" onclick="this.parentElement.remove()" class="w-6 text-red-300 hover:text-red-500 transition-colors">✕</button>
    `;
    container.appendChild(row);
}
</script>
@endsection
