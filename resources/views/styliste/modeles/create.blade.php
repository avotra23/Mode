@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#FDFCFB] py-12 px-6">
    <div class="max-w-5xl mx-auto">
        
        <a href="{{ route('styliste.dashboard') }}" class="inline-flex items-center text-[10px] uppercase tracking-[0.3em] text-gray-400 hover:text-orange-800 transition-colors mb-8 group">
            <svg class="w-3 h-3 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Retour au Dashboard
        </a>

        <div class="bg-white shadow-[0_40px_100px_rgba(0,0,0,0.03)] rounded-3xl overflow-hidden border border-orange-50/50">
            
            <div class="px-10 py-8 border-b border-orange-50 bg-white flex justify-between items-end">
                <div>
                    <span class="text-orange-800 text-[9px] font-bold uppercase tracking-[0.5em] block mb-2">Fiche Technique</span>
                    <h1 class="text-4xl font-serif italic text-[#2D241E]">Nouvelle Création</h1>
                </div>
                <div class="text-right hidden md:block">
                    <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold">Statut</p>
                    <p class="font-serif italic text-orange-800/60">Nouvelle</p>
                </div>
            </div>

            <form action="{{ route('styliste.modeles.store') }}" method="POST" enctype="multipart/form-data" class="p-10 lg:p-14">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
                    
                    <div class="lg:col-span-7 space-y-12">
                        
                        <div class="group">
                            <label class="text-[10px] uppercase tracking-[0.2em] text-gray-400 font-bold mb-3 block group-focus-within:text-orange-800 transition-colors">Collection Référente</label>
                            <div class="relative">
                                <select name="collection_id" class="w-full border-0 border-b-2 border-gray-100 focus:border-orange-800 focus:ring-0 text-lg font-serif italic py-3 bg-transparent cursor-pointer transition-all">
                                    @foreach($collections as $c)
                                        <option value="{{ $c->id }}" {{ $selected_collection == $c->id ? 'selected' : '' }}>{{ $c->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="group">
                            <label class="text-[10px] uppercase tracking-[0.2em] text-gray-400 font-bold mb-3 block group-focus-within:text-orange-800 transition-colors">Nom du Modèle</label>
                            <input type="text" name="nom" class="w-full border-0 border-b-2 border-gray-100 focus:border-orange-800 focus:ring-0 text-2xl font-serif italic py-3 bg-transparent placeholder:text-gray-200 transition-all" placeholder="ex: Robe de Soirée 'Éclat'" required>
                        </div>

                        <div class="group">
                            <label class="text-[10px] uppercase tracking-[0.2em] text-gray-400 font-bold mb-3 block group-focus-within:text-orange-800 transition-colors">Note de Style & Finitions</label>
                            <textarea name="description" rows="4" class="w-full border-2 border-gray-50 rounded-2xl bg-gray-50/30 text-sm p-6 focus:border-orange-100 focus:bg-white focus:ring-0 transition-all placeholder:italic leading-relaxed" placeholder="Détaillez la coupe, les matières, les inspirations..."></textarea>
                        </div>

                        <div class="group inline-block">
                            <label class="text-[10px] uppercase tracking-[0.2em] text-gray-400 font-bold mb-3 block group-focus-within:text-orange-800 transition-colors">Valeur Estimeé (FCFA)</label>
                            <div class="flex items-baseline gap-4">
                                <input type="number" name="prix_base" class="w-48 border-0 border-b-2 border-gray-100 focus:border-orange-800 focus:ring-0 text-3xl font-bold py-2 bg-transparent text-orange-950 transition-all" placeholder="0" required>
                                <span class="text-xl font-serif italic text-gray-300">CFA</span>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-5 space-y-10">
                        
                        <div class="bg-[#F9F7F4] p-8 rounded-3xl border border-orange-100/50 shadow-inner">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-[10px] uppercase tracking-[0.3em] text-[#2D241E] font-black italic">Tailles & Stocks</h3>
                                <button type="button" onclick="addSizeRow()" class="text-[9px] bg-[#2D241E] text-white px-4 py-2 rounded-full uppercase font-bold hover:bg-orange-800 transition-all shadow-lg shadow-black/10">+ Ajouter</button>
                            </div>

                            <div id="size-container" class="space-y-4">
                                <div class="flex gap-3 items-center bg-white p-3 rounded-xl shadow-sm border border-orange-50 animate-fadeIn">
                                    <input type="text" name="noms_tailles[]" placeholder="Taille (S, M, L...)" class="flex-1 border-0 text-xs font-bold py-1 focus:ring-0" required>
                                    <div class="h-4 w-px bg-gray-100"></div>
                                    <input type="number" name="stocks_tailles[]" placeholder="Stock" class="w-20 border-0 text-xs text-center font-bold py-1 focus:ring-0" required>
                                    <div class="w-6"></div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <label class="text-[10px] uppercase tracking-[0.2em] text-gray-400 font-bold block">Photographies du modèle</label>
                            <div class="relative group">
                                <div class="border-2 border-dashed border-orange-100 rounded-3xl p-10 text-center bg-white group-hover:bg-orange-50/30 group-hover:border-orange-200 transition-all duration-500">
                                    <input type="file" name="images[]" multiple class="absolute inset-0 opacity-0 cursor-pointer z-10">
                                    <div class="space-y-4">
                                        <div class="w-16 h-16 bg-orange-50 rounded-full flex items-center justify-center mx-auto group-hover:scale-110 transition-transform duration-500">
                                            <svg class="w-8 h-8 text-orange-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <div>
                                            <span class="text-xs text-[#2D241E] font-bold block">Cliquez pour importer</span>
                                            <p class="text-[9px] text-gray-400 mt-1 uppercase tracking-widest leading-relaxed">Multiples fichiers acceptés <br> (Haute définition recommandée)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-16 pt-10 border-t border-orange-50">
                    <a href="{{ route('styliste.dashboard') }}" class="text-[10px] uppercase tracking-[0.3em] text-gray-400 hover:text-red-600 font-black transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        Abandonner le projet
                    </a>
                    
                    <button type="submit" class="group relative overflow-hidden bg-[#2D241E] text-white px-12 py-5 rounded-full text-[11px] font-bold uppercase tracking-[0.4em] transition-all hover:scale-105 shadow-2xl shadow-[#2D241E]/20">
                        <span class="relative z-10">Enregistrer dans l'Atelier</span>
                        <div class="absolute inset-0 bg-orange-800 translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function addSizeRow() {
    const container = document.getElementById('size-container');
    const row = document.createElement('div');
    row.className = 'flex gap-3 items-center bg-white p-3 rounded-xl shadow-sm border border-orange-50 animate-slideUp';
    row.innerHTML = `
        <input type="text" name="noms_tailles[]" placeholder="Taille" class="flex-1 border-0 text-xs font-bold py-1 focus:ring-0" required>
        <div class="h-4 w-px bg-gray-100"></div>
        <input type="number" name="stocks_tailles[]" placeholder="Qté" class="w-20 border-0 text-xs text-center font-bold py-1 focus:ring-0" required>
        <button type="button" onclick="this.parentElement.remove()" class="w-6 text-gray-300 hover:text-red-500 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    `;
    container.appendChild(row);
}
</script>

<style>
@keyframes slideUp {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-slideUp { animation: slideUp 0.4s ease-out forwards; }
</style>
@endsection