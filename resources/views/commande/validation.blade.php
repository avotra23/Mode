@extends('layouts.app')

@section('content')
<div class="bg-[#FCFBFA] min-h-screen pb-20" 
     x-data="{ 
        items: JSON.parse(localStorage.getItem('cart') || '[]'),
        submitted: false,
        submitForm() {
            localStorage.removeItem('cart');
            this.submitted = true;
            setTimeout(() => { document.getElementById('orderForm').submit(); }, 3000);
        }
     }">
    
    <div class="max-w-6xl mx-auto px-6 pt-32">
        
        <div x-show="!submitted" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 y-4">
            <div class="mb-12">
                <h1 class="text-5xl font-serif italic text-[#2D241E]">Personnalisation</h1>
                <div class="flex items-center gap-4 mt-4">
                    <div class="h-px w-12 bg-orange-700"></div>
                    <p class="text-gray-500 uppercase tracking-[0.3em] text-[10px] font-bold">Atelier de confection artisanale</p>
                </div>
            </div>

            <form action="{{ route('commande.store') }}" method="POST" id="orderForm" @submit.prevent="submitForm">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
                    
                    <div class="lg:col-span-7 space-y-10">
                        <template x-for="(item, index) in items" :key="item.id">
                            <div class="group bg-white border-b border-orange-100 pb-10 flex gap-8 transition-all">
                                <div class="relative w-40 h-56 flex-shrink-0 overflow-hidden bg-gray-50">
                                    <img :src="item.image" class="w-full h-full object-cover grayscale-[0.2] group-hover:grayscale-0 transition-all duration-500">
                                    <div class="absolute inset-0 border-[10px] border-white/20"></div>
                                </div>

                                <div class="flex-1 space-y-6">
                                    <div class="flex justify-between items-start">
                                        <h3 class="font-serif text-2xl text-[#2D241E]" x-text="item.nom"></h3>
                                        <span class="text-sm font-bold text-orange-800" x-text="item.prix.toLocaleString() + ' FCFA'"></span>
                                    </div>
                                    
                                    <input type="hidden" :name="'articles['+index+'][modele_id]'" :value="item.id">

                                    <div class="grid grid-cols-2 gap-6">
                                        <div class="space-y-1">
                                            <label class="block text-[10px] uppercase font-bold text-gray-400 tracking-widest">Taille désirée</label>
                                            <select :name="'articles['+index+'][taille]'" x-model="item.taille" 
                                                    class="w-full border-0 border-b border-gray-200 bg-transparent text-sm focus:ring-0 focus:border-orange-700 py-2 pl-0 transition-all">
                                                <option value="XS">XS — Très Petit</option>
                                                <option value="S">S — Petit</option>
                                                <option value="M">M — Standard</option>
                                                <option value="L">L — Large</option>
                                                <option value="XL">XL — Très Large</option>
                                            </select>
                                        </div>
                                        <div class="space-y-1">
                                            <label class="block text-[10px] uppercase font-bold text-gray-400 tracking-widest">Choix du Tissu</label>
                                            <select :name="'articles['+index+'][tissu]'" 
                                                    class="w-full border-0 border-b border-gray-200 bg-transparent text-sm focus:ring-0 focus:border-orange-700 py-2 pl-0 transition-all">
                                                <option>Coton Bio d'Afrique</option>
                                                <option>Soie Sauvage</option>
                                                <option>Lin Premium</option>
                                                <option>Bazin Riche</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="space-y-1">
                                        <label class="block text-[10px] uppercase font-bold text-gray-400 tracking-widest">Notes de confection (Mesures précises)</label>
                                        <textarea :name="'articles['+index+'][commentaires]'" 
                                                  class="w-full border-gray-100 bg-gray-50/50 text-sm italic focus:ring-0 focus:border-orange-200 p-4 resize-none" 
                                                  rows="2" placeholder="Ex: Tour de poitrine 95cm, manches plus courtes..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div class="lg:col-span-5">
                        <div class="bg-white p-10 shadow-[0_30px_60px_rgba(0,0,0,0.04)] border border-orange-50 sticky top-32">
                            <h2 class="font-serif text-3xl mb-8 italic text-[#2D241E]">Finalisation</h2>
                            
                            <div class="space-y-8">
                                <div class="space-y-4">
                                    <div class="group">
                                        <label class="block text-[10px] uppercase font-bold text-gray-400 mb-2 tracking-widest">Méthode de Paiement Mobile</label>
                                        <div class="grid grid-cols-3 gap-2">
                                            <label class="cursor-pointer">
                                                <input type="radio" name="operateur" value="mvola" class="hidden peer" required>
                                                <div class="text-[10px] font-bold text-center py-3 border border-gray-100 peer-checked:border-[#2D241E] peer-checked:bg-[#2D241E] peer-checked:text-white transition-all uppercase">M-Vola</div>
                                            </label>
                                            <label class="cursor-pointer">
                                                <input type="radio" name="operateur" value="orange" class="hidden peer">
                                                <div class="text-[10px] font-bold text-center py-3 border border-gray-100 peer-checked:border-orange-600 peer-checked:bg-orange-600 peer-checked:text-white transition-all uppercase">Orange</div>
                                            </label>
                                            <label class="cursor-pointer">
                                                <input type="radio" name="operateur" value="airtel" class="hidden peer">
                                                <div class="text-[10px] font-bold text-center py-3 border border-gray-100 peer-checked:border-red-600 peer-checked:bg-red-600 peer-checked:text-white transition-all uppercase">Airtel</div>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        <label class="block text-[10px] uppercase font-bold text-gray-400 tracking-widest">Numéro de transaction</label>
                                        <input type="tel" name="telephone" required placeholder="03X XX XXX XX"
                                               class="w-full border-gray-100 bg-gray-50/50 py-4 text-center text-xl tracking-[0.2em] focus:ring-0 focus:border-orange-700 transition-all font-light">
                                    </div>
                                </div>

                                <div class="pt-8 border-t border-orange-50 space-y-4">
                                    <div class="flex justify-between items-center">
                                        <span class="text-[10px] uppercase font-bold text-gray-400 tracking-widest">Sous-total</span>
                                        <span class="text-sm font-bold" x-text="items.reduce((sum, i) => sum + i.prix, 0).toLocaleString() + ' FCFA'"></span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-[10px] uppercase font-bold text-gray-400 tracking-widest">Confection</span>
                                        <span class="text-[10px] font-bold text-green-600 uppercase italic">Incluse</span>
                                    </div>
                                    <div class="flex justify-between items-center pt-4 border-t border-gray-50">
                                        <span class="font-serif text-2xl italic">Montant Total</span>
                                        <span class="text-2xl font-bold text-[#2D241E]" x-text="items.reduce((sum, i) => sum + i.prix, 0).toLocaleString() + ' FCFA'"></span>
                                    </div>

                                    <button type="submit" 
                                            class="w-full bg-[#2D241E] text-white py-6 rounded-none font-bold uppercase tracking-[0.2em] text-[11px] hover:bg-orange-700 transition-all shadow-2xl shadow-gray-200 mt-6 active:scale-[0.98]">
                                        Lancer la confection
                                    </button>
                                    
                                    <p class="text-center text-[9px] text-gray-400 uppercase tracking-widest mt-4">
                                        Paiement sécurisé par cryptage SSL
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div x-show="submitted" x-transition.opacity.duration.500ms class="fixed inset-0 z-[100] flex items-center justify-center bg-[#FCFBFA]/95 p-6">
            <div class="max-w-xl w-full bg-white border border-orange-100 p-16 text-center shadow-2xl relative">
                <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-8">
                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                
                <h2 class="font-serif text-4xl italic mb-4">Commande confirmée</h2>
                <p class="text-gray-500 uppercase tracking-widest text-[10px] mb-8 font-bold">Votre voyage de style commence ici</p>
                
                <div class="bg-gray-50 p-8 mb-8 border-y border-gray-100 italic font-serif text-gray-600 leading-relaxed">
                    "Chaque pièce est découpée et cousue à la main. Notre maître tailleur prendra soin de vos spécifications avec la plus grande attention."
                </div>

                <div class="animate-pulse flex flex-col items-center space-y-2">
                    <p class="text-sm text-[#2D241E]">Redirection vers votre tableau de bord...</p>
                    <div class="h-0.5 w-12 bg-orange-700"></div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection