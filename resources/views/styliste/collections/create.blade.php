@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-16 px-6">
    <div class="bg-white border border-gray-100 shadow-sm rounded-xl overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-50">
            <h1 class="text-xl font-medium text-gray-800 tracking-tight">Nouvelle Collection</h1>
            <p class="text-xs text-gray-400 mt-1">Enregistrez les détails de votre prochaine saison.</p>
        </div>

        <form action="{{ route('styliste.collections.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
            @csrf

            <div class="space-y-2">
                <label class="text-[11px] uppercase tracking-widest text-gray-500 font-semibold">Nom de la collection</label>
                <input type="text" name="nom" class="w-full border-gray-200 rounded-lg focus:border-indigo-500 focus:ring-0 text-sm py-3 transition-colors" placeholder="Ex: Été Indien" required>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-[11px] uppercase tracking-widest text-gray-500 font-semibold">Saison</label>
                    <select name="saison" class="w-full border-gray-200 rounded-lg text-sm py-3 focus:ring-0">
                        <option>Printemps/Été</option>
                        <option>Automne/Hiver</option>
                        <option>Croisière</option>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-[11px] uppercase tracking-widest text-gray-500 font-semibold">Année</label>
                    <input type="number" name="annee" value="{{ date('Y') }}" class="w-full border-gray-200 rounded-lg text-sm py-3 focus:ring-0" required>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-[11px] uppercase tracking-widest text-gray-500 font-semibold">Description</label>
                <textarea name="description" rows="3" class="w-full border-gray-200 rounded-lg text-sm p-4 focus:ring-0" placeholder="L'histoire de cette collection..."></textarea>
            </div>

            <div class="space-y-2">
                <label class="text-[11px] uppercase tracking-widest text-gray-500 font-semibold">Image de couverture</label>
                <div class="border border-dashed border-gray-200 rounded-lg p-8 text-center bg-gray-50/30 hover:bg-gray-50 transition-colors">
                    <input type="file" name="image" id="image" class="hidden" required onchange="updateFileName(this)">
                    <label for="image" class="cursor-pointer">
                        <span id="file-chosen" class="text-xs text-gray-600 font-medium">Cliquer pour uploader une photo</span>
                        <p class="text-[10px] text-gray-400 mt-1 uppercase">Format portrait recommandé</p>
                    </label>
                </div>
            </div>

            <div class="flex items-center justify-between pt-4">
                <a href="{{ route('styliste.dashboard') }}" class="text-xs text-red-400 hover:text-gray-600 transition">Annuler</a>
                <button type="submit" class="bg-gray-900 text-white px-8 py-3 rounded-lg text-xs font-semibold tracking-wide hover:bg-black transition-all shadow-sm">
                    Créer la collection
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function updateFileName(input) {
    const fileName = input.files[0].name;
    document.getElementById('file-chosen').textContent = fileName;
}
</script>
@endsection
