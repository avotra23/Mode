@extends('layouts.app')

@section('content')
<div class="relative min-h-screen bg-[#FDFCFB] overflow-hidden">
    
    <div class="absolute top-0 -left-20 w-96 h-96 bg-orange-100/40 rounded-full blur-[100px] pointer-events-none"></div>
    <div class="absolute bottom-0 -right-20 w-[500px] h-[500px] bg-[#2D241E]/5 rounded-full blur-[120px] pointer-events-none"></div>
    
    <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: url('https://www.transparenttextures.com/patterns/natural-paper.png');"></div>

    <div class="relative max-w-3xl mx-auto py-16 px-6">
        <div class="mb-10 text-center">
            <span class="inline-block px-4 py-1.5 mb-4 border border-orange-200 text-[9px] uppercase tracking-[0.4em] text-orange-800 font-bold rounded-full bg-orange-50/50">
                Studio de Design
            </span>
            <h1 class="text-5xl font-serif italic text-[#2D241E] leading-tight">Nouvelle <br>Collection</h1>
            <div class="h-0.5 w-16 bg-orange-700 mx-auto mt-6"></div>
        </div>

        <div class="bg-white/80 backdrop-blur-xl shadow-[0_40px_100px_rgba(45,36,30,0.12)] rounded-3xl overflow-hidden border border-white relative">
            
            <div class="absolute top-0 right-0 p-8 pointer-events-none opacity-10">
                <i class="fa-solid fa-pen-nib text-6xl text-[#2D241E]"></i>
            </div>

            <form action="{{ route('styliste.collections.store') }}" method="POST" enctype="multipart/form-data" class="p-10 lg:p-14 space-y-12">
                @csrf

                <div class="relative group">
                    <label class="text-[10px] uppercase tracking-[0.2em] text-orange-900/40 font-black mb-3 block transition-colors group-focus-within:text-orange-700">Identité du projet</label>
                    <input type="text" name="nom" 
                        class="w-full border-0 border-b-2 border-gray-100 focus:border-orange-800 focus:ring-0 text-3xl font-serif italic py-4 transition-all bg-transparent placeholder:text-gray-200" 
                        placeholder="Nom de la collection..." required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <div class="space-y-3">
                        <label class="text-[10px] uppercase tracking-[0.2em] text-orange-900/40 font-black">Temporalité</label>
                        <select name="saison" class="w-full border-0 border-b border-gray-100 bg-transparent text-sm py-4 focus:border-orange-800 focus:ring-0 transition-all cursor-pointer">
                            <option>Printemps/Été</option>
                            <option>Automne/Hiver</option>
                            <option>Croisière</option>
                            <option>Haute Couture</option>
                        </select>
                    </div>

                    <div class="space-y-3">
                        <label class="text-[10px] uppercase tracking-[0.2em] text-orange-900/40 font-black">Millésime</label>
                        <input type="number" name="annee" value="{{ date('Y') }}" 
                            class="w-full border-0 border-b border-gray-100 bg-transparent text-sm py-4 focus:border-orange-800 focus:ring-0 transition-all" required>
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="text-[10px] uppercase tracking-[0.2em] text-orange-900/40 font-black">Manifeste / Inspiration</label>
                    <textarea name="description" rows="4" 
                        class="w-full border-2 border-gray-50 rounded-2xl bg-gray-50/30 text-sm p-6 focus:border-orange-100 focus:bg-white focus:ring-0 transition-all placeholder:italic leading-relaxed" 
                        placeholder="Quelle est l'histoire derrière ces pièces ?"></textarea>
                </div>

                <div class="space-y-4">
                    <label class="text-[10px] uppercase tracking-[0.2em] text-orange-900/40 font-black">Image de Couverture</label>
                    <div x-data="imageViewer()" class="relative">
                        <input type="file" name="image" id="image" class="hidden" accept="image/*" @change="fileChosen" required>
                        
                        <label for="image" class="group cursor-pointer block">
                            <div class="relative border-2 border-dashed border-orange-100 rounded-3xl p-10 text-center bg-orange-50/20 group-hover:bg-orange-50/50 group-hover:border-orange-300 transition-all duration-500 overflow-hidden">
                                
                                <template x-if="!imageUrl">
                                    <div class="space-y-4 py-8">
                                        <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto shadow-sm group-hover:scale-110 transition-transform duration-500">
                                            <i class="fa-solid fa-plus text-orange-800 text-2xl"></i>
                                        </div>
                                        <div class="space-y-1">
                                            <span class="text-xs text-[#2D241E] font-bold uppercase tracking-widest">Sélectionner un visuel</span>
                                            <p class="text-[9px] text-gray-400 uppercase tracking-widest">Portrait recommandé (3:4)</p>
                                        </div>
                                    </div>
                                </template>

                                <template x-if="imageUrl">
                                    <div class="relative w-full max-w-sm mx-auto aspect-[3/4] rounded-xl overflow-hidden shadow-2xl ring-8 ring-white/50">
                                        <img :src="imageUrl" class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-[#2D241E]/60 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-all duration-300">
                                            <div class="px-6 py-3 border border-white text-white text-[10px] uppercase tracking-[0.3em] font-bold">
                                                Remplacer l'image
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-between gap-8 pt-10">
                    <a href="{{ route('styliste.dashboard') }}" class="text-[9px] uppercase tracking-[0.3em] text-gray-400 hover:text-red-800 font-black transition-colors">
                       <i class="fa-solid fa-xmark mr-2"></i> Abandonner
                    </a>
                    
                    <button type="submit" class="group relative w-full sm:w-auto overflow-hidden bg-[#2D241E] text-white px-14 py-6 rounded-full text-[11px] font-bold uppercase tracking-[0.4em] transition-all hover:scale-105 active:scale-95 shadow-2xl shadow-[#2D241E]/20">
                        <span class="relative z-10">Publier la Collection</span>
                        <div class="absolute inset-0 bg-orange-700 translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                    </button>
                </div>
            </form>
        </div>
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

<style>
    /* Animation douce pour l'apparition */
    .font-serif {
        font-family: 'Playfair Display', serif;
    }
</style>
@endsection