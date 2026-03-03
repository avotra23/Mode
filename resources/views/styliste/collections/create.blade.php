@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-16 px-6">
    <div class="mb-10 text-center">
        <h1 class="text-4xl font-serif italic text-[#2D241E]">Nouvelle Collection</h1>
        <div class="h-0.5 w-16 bg-orange-700 mx-auto mt-4"></div>
        <p class="text-sm text-gray-500 mt-4 uppercase tracking-[0.2em]">Atelier de Création</p>
    </div>

    <div class="bg-white shadow-[0_20px_50px_rgba(0,0,0,0.05)] rounded-2xl overflow-hidden border border-orange-50">
        <form action="{{ route('styliste.collections.store') }}" method="POST" enctype="multipart/form-data" class="p-10 space-y-10">
            @csrf

            <div class="relative group">
                <label class="text-[10px] uppercase tracking-[0.2em] text-gray-400 font-bold mb-2 block transition-colors group-focus-within:text-orange-700">Nom de l'œuvre</label>
                <input type="text" name="nom" 
                    class="w-full border-0 border-b border-gray-200 focus:border-orange-700 focus:ring-0 text-xl font-serif italic py-3 transition-all placeholder:text-gray-200" 
                    placeholder="Ex: Été Indien" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-2">
                    <label class="text-[10px] uppercase tracking-[0.2em] text-gray-400 font-bold">Saison</label>
                    <select name="saison" class="w-full border-gray-100 rounded-none bg-gray-50/50 text-sm py-4 focus:border-orange-700 focus:ring-0 transition-all">
                        <option>Printemps/Été</option>
                        <option>Automne/Hiver</option>
                        <option>Croisière</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] uppercase tracking-[0.2em] text-gray-400 font-bold">Année de sortie</label>
                    <input type="number" name="annee" value="{{ date('Y') }}" 
                        class="w-full border-gray-100 rounded-none bg-gray-50/50 text-sm py-4 focus:border-orange-700 focus:ring-0 transition-all" required>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] uppercase tracking-[0.2em] text-gray-400 font-bold">L'inspiration / Histoire</label>
                <textarea name="description" rows="4" 
                    class="w-full border-gray-100 rounded-none bg-gray-50/50 text-sm p-4 focus:border-orange-700 focus:ring-0 transition-all placeholder:italic" 
                    placeholder="Décrivez l'univers de cette collection..."></textarea>
            </div>

            <div class="space-y-4">
                <label class="text-[10px] uppercase tracking-[0.2em] text-gray-400 font-bold">Visuel de couverture</label>
                <div x-data="imageViewer()" class="relative">
                    <input type="file" name="image" id="image" class="hidden" accept="image/*" @change="fileChosen" required>
                    
                    <label for="image" class="group cursor-pointer block">
                        <div class="border-2 border-dashed border-orange-100 rounded-2xl p-12 text-center bg-orange-50/10 group-hover:bg-orange-50/30 group-hover:border-orange-200 transition-all duration-300">
                            <template x-if="!imageUrl">
                                <div class="space-y-4">
                                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto shadow-sm group-hover:scale-110 transition-transform">
                                        <i class="fa-solid fa-camera text-orange-700 text-xl"></i>
                                    </div>
                                    <div>
                                        <span class="text-sm text-[#2D241E] font-medium">Importer un visuel</span>
                                        <p class="text-[10px] text-gray-400 mt-2 uppercase tracking-widest">JPG, PNG haute résolution</p>
                                    </div>
                                </div>
                            </template>

                            <template x-if="imageUrl">
                                <div class="relative w-full max-w-xs mx-auto aspect-[3/4] rounded-lg overflow-hidden shadow-2xl">
                                    <img :src="imageUrl" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
                                        <span class="text-white text-xs uppercase tracking-widest font-bold">Changer l'image</span>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </label>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-6 pt-8 border-t border-orange-50">
                <a href="{{ route('styliste.dashboard') }}" class="text-[10px] uppercase tracking-widest text-gray-400 hover:text-red-700 font-bold transition">
                   ← Annuler la publication
                </a>
                <button type="submit" class="w-full sm:w-auto bg-[#2D241E] text-white px-12 py-5 rounded-none text-[11px] font-bold uppercase tracking-[0.3em] hover:bg-orange-700 transition-all shadow-xl shadow-gray-200 hover:shadow-orange-700/20">
                    Publier la Collection
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function imageViewer() {
    return {
        imageUrl: '',
        fileChosen(event) {
            this.fileToDataUrl(event, src => this.imageUrl = src);
        },
        fileToDataUrl(event, callback) {
            if (!event.target.files.length) return;
            let file = event.target.files[0],
                reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = e => callback(e.target.result);
        }
    }
}
</script>
@endsection