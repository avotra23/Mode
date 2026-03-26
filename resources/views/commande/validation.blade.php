@extends('layouts.app')

@section('content')
<div class="bg-[#F9F7F4] min-h-screen pb-32" 
     x-data="{ 
        items: JSON.parse(localStorage.getItem('cart') || '[]'),
        submitted: false,
        submitForm() {
            this.submitted = true;
            localStorage.removeItem('cart');
            document.getElementById('orderForm').submit();
            setTimeout(() => {
                window.location.href = '{{ route('catalogue.index') }}';
            }, 6000);
        }
     }">
    
    <div class="max-w-7xl mx-auto px-8 pt-36">
        
        <div x-show="!submitted" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 translate-y-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-20 border-b border-orange-100 pb-12">
                <div>
                    <span class="text-orange-700 text-[11px] font-bold uppercase tracking-[0.5em] block mb-4">Sur-mesure</span>
                    <h1 class="text-6xl font-serif text-[#2D241E] leading-tight">Finaliser votre <br><span class="italic text-orange-800/80">confection</span></h1>
                </div>
                <div class="mt-8 md:mt-0 text-right">
                    <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold">Étape finale</p>
                    <p class="font-serif italic text-lg text-[#2D241E]">Artisanat & Excellence</p>
                </div>
            </div>

            <form action="{{ route('commande.store') }}" method="POST" id="orderForm" @submit.prevent="submitForm">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-20">
                    
                    <div class="lg:col-span-7 space-y-16">
                        <template x-for="(item, index) in items" :key="item.id">
                            <div class="group relative flex flex-col md:flex-row gap-10 transition-all duration-500">
                                <div class="relative w-full md:w-56 h-72 flex-shrink-0 overflow-hidden shadow-sm">
                                    <img :src="item.image" class="w-full h-full object-cover scale-105 group-hover:scale-110 transition-transform duration-700">
                                    <div class="absolute inset-0 bg-black/5 group-hover:bg-transparent transition-colors"></div>
                                    <div class="absolute inset-4 border border-white/30 pointer-events-none"></div>
                                </div>

                                <div class="flex-1">
                                    <div class="flex justify-between items-baseline mb-6">
                                        <h3 class="font-serif text-3xl text-[#2D241E]" x-text="item.nom"></h3>
                                        <span class="h-px flex-1 mx-4 bg-orange-100"></span>
                                        <span class="font-bold text-orange-900 tracking-tighter" x-text="item.prix.toLocaleString() + ' FCFA'"></span>
                                    </div>
                                    
                                    <input type="hidden" :name="'articles['+index+'][modele_id]'" :value="item.id">

                                    <div class="grid grid-cols-2 gap-8 mb-8">
                                        <div class="relative group/select">
                                            <label class="text-[9px] uppercase font-black text-orange-900/40 tracking-[0.2em] mb-2 block">Mesure standard</label>
                                            <select :name="'articles['+index+'][taille]'" x-model="item.taille" 
                                                    class="w-full border-0 border-b-2 border-orange-50 bg-transparent text-sm focus:ring-0 focus:border-[#2D241E] py-3 pl-0 transition-all appearance-none cursor-pointer">
                                                <option value="XS">XS — Smallest</option>
                                                <option value="S">S — Small</option>
                                                <option value="M">M — Medium</option>
                                                <option value="L">L — Large</option>
                                                <option value="XL">XL — Extra Large</option>
                                            </select>
                                        </div>
                                        <div class="relative">
                                            <label class="text-[9px] uppercase font-black text-orange-900/40 tracking-[0.2em] mb-2 block">Sélection Textile</label>
                                            <select :name="'articles['+index+'][tissu]'" 
                                                    class="w-full border-0 border-b-2 border-orange-50 bg-transparent text-sm focus:ring-0 focus:border-[#2D241E] py-3 pl-0 transition-all appearance-none cursor-pointer">
                                                <option>Coton Bio d'Afrique</option>
                                                <option>Soie Sauvage</option>
                                                <option>Lin Premium</option>
                                                <option>Bazin Riche</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="text-[9px] uppercase font-black text-orange-900/40 tracking-[0.2em] mb-2 block">Instructions particulières</label>
                                        <textarea :name="'articles['+index+'][commentaires]'" 
                                                  class="w-full border-0 bg-[#FDFDFD] text-sm italic focus:ring-0 focus:bg-white border-l-2 border-orange-100 focus:border-orange-800 p-4 transition-all resize-none" 
                                                  rows="2" placeholder="Ex: Longueur manche +2cm..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div class="lg:col-span-5">
                        <div class="bg-white p-12 shadow-[0_40px_100px_rgba(45,36,30,0.08)] border border-orange-100/50 sticky top-32 relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-orange-50/30 rounded-full -mr-16 -mt-16 blur-3xl"></div>
                            
                            <h2 class="font-serif text-3xl mb-10 text-[#2D241E] flex items-center gap-3">
                                <span>Règlement</span>
                                <span class="h-px w-8 bg-orange-200"></span>
                            </h2>
                            
                            <div class="space-y-10 relative z-10">
                                <div class="space-y-6">
                                    <div class="group">
                                        <label class="block text-[10px] uppercase font-bold text-gray-400 mb-4 tracking-widest text-center">Opérateur Mobile</label>
                                        <div class="grid grid-cols-3 gap-3">
                                            <label class="cursor-pointer group/opt">
                                                <input type="radio" name="operateur" value="mvola" class="hidden peer" required>
                                                <div class="text-[9px] font-bold text-center py-4 border border-gray-100 peer-checked:border-[#2D241E] peer-checked:bg-[#2D241E] peer-checked:text-white transition-all uppercase tracking-tighter">M-Vola</div>
                                            </label>
                                            <label class="cursor-pointer group/opt">
                                                <input type="radio" name="operateur" value="orange" class="hidden peer">
                                                <div class="text-[9px] font-bold text-center py-4 border border-gray-100 peer-checked:border-orange-600 peer-checked:bg-orange-600 peer-checked:text-white transition-all uppercase tracking-tighter">Orange</div>
                                            </label>
                                            <label class="cursor-pointer group/opt">
                                                <input type="radio" name="operateur" value="airtel" class="hidden peer">
                                                <div class="text-[9px] font-bold text-center py-4 border border-gray-100 peer-checked:border-red-600 peer-checked:bg-red-600 peer-checked:text-white transition-all uppercase tracking-tighter">Airtel</div>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="space-y-3">
                                        <label class="block text-[10px] uppercase font-bold text-gray-400 tracking-widest text-center">Référence Transaction</label>
                                        <input type="tel" name="telephone" required placeholder="03X XX XXX XX"
                                               class="w-full border-0 border-b-2 border-gray-100 bg-gray-50/30 py-4 text-center text-2xl tracking-[0.3em] focus:ring-0 focus:border-[#2D241E] focus:bg-white transition-all font-light placeholder:text-gray-200">
                                    </div>
                                </div>

                                <div class="pt-10 border-t border-orange-50 space-y-5">
                                    <div class="flex justify-between items-center text-[11px] uppercase tracking-widest text-gray-500">
                                        <span>Création artisanale</span>
                                        <span class="font-bold text-[#2D241E]" x-text="items.reduce((sum, i) => sum + i.prix, 0).toLocaleString() + ' FCFA'"></span>
                                    </div>
                                    <div class="flex justify-between items-center text-[11px] uppercase tracking-widest text-gray-500">
                                        <span>Livraison Atelier</span>
                                        <span class="text-green-700 font-bold">Offerte</span>
                                    </div>
                                    <div class="flex justify-between items-center pt-6 border-t border-[#2D241E]/5">
                                        <span class="font-serif text-3xl italic text-[#2D241E]">Total</span>
                                        <span class="text-3xl font-bold text-[#2D241E] tracking-tighter" x-text="items.reduce((sum, i) => sum + i.prix, 0).toLocaleString() + ' FCFA'"></span>
                                    </div>

                                    <button type="submit" 
                                            class="w-full bg-[#2D241E] text-white py-7 rounded-none font-bold uppercase tracking-[0.3em] text-[12px] hover:bg-orange-800 transition-all duration-500 shadow-xl mt-8 flex items-center justify-center gap-4 group">
                                        <span>Commander & Recevoir Facture</span>
                                        <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div x-show="submitted" x-transition.opacity.duration.800ms class="fixed inset-0 z-[100] flex items-center justify-center bg-[#F9F7F4]/98 backdrop-blur-sm p-6">
            <div class="max-w-2xl w-full text-center relative">
                <div class="relative w-32 h-32 mx-auto mb-12">
                    <div class="absolute inset-0 border-2 border-orange-100 rounded-full animate-ping opacity-25"></div>
                    <div class="relative w-32 h-32 bg-white border border-orange-100 rounded-full flex items-center justify-center shadow-inner">
                        <svg class="w-12 h-12 text-orange-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
                
                <h2 class="font-serif text-6xl text-[#2D241E] mb-6 tracking-tight">Merci, <span class="italic">Manda</span></h2>
                <p class="text-orange-800 uppercase tracking-[0.6em] text-[11px] mb-12 font-black">L'excellence prend forme</p>
                
                <div class="max-w-md mx-auto bg-white p-10 border border-orange-50 shadow-sm mb-12">
                    <p class="font-serif italic text-lg text-gray-600 leading-relaxed">
                        "Votre commande a été transmise à nos ateliers. Votre facture PDF est en cours de génération et sera téléchargée automatiquement."
                    </p>
                </div>

                <div class="flex flex-col items-center gap-6">
                    <div class="flex items-center gap-4">
                        <div class="w-2 h-2 bg-orange-800 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                        <div class="w-2 h-2 bg-orange-800 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                        <div class="w-2 h-2 bg-orange-800 rounded-full animate-bounce" style="animation-delay: 0.3s"></div>
                    </div>
                    <p class="text-[10px] uppercase tracking-[0.4em] text-gray-400 font-bold">Préparation de vos documents...</p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection