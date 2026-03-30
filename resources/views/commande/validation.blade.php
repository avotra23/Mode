@extends('layouts.app')

@section('content')
<div class="bg-[#F9F7F4] min-h-screen pb-32" 
    x-data="{ 
        items: JSON.parse(localStorage.getItem('cart') || '[]'),
        submitted: false,
        currency: 'FCFA',
        rates: {
            'FCFA': 1,
            'EURO': 0.0015,
            'USD': 0.0017,
            'AR': 7.5
        },
        formatPrice(price) {
            const converted = price * this.rates[this.currency];
            return new Intl.NumberFormat('fr-FR').format(Math.round(converted)) + ' ' + this.currency;
        },
        submitForm() {
            this.submitted = true;
            localStorage.removeItem('cart');
            // On laisse un petit délai pour l'animation avant de soumettre réellement
            setTimeout(() => {
                document.getElementById('orderForm').submit();
            }, 2000);
            
            setTimeout(() => {
                window.location.href = '{{ route('catalogue.index') }}';
            }, 8000);
        }
    }">
    
    <div class="max-w-7xl mx-auto px-8 pt-36">
        
        <div x-show="!submitted" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 translate-y-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-20 border-b border-orange-100 pb-12">
                <div>
                    <span class="text-orange-700 text-[11px] font-bold uppercase tracking-[0.5em] block mb-4">Sur-mesure</span>
                    <h1 class="text-6xl font-serif text-[#2D241E] leading-tight">Finaliser votre <br><span class="italic text-orange-800/80">confection</span></h1>
                </div>
                
                <div class="mt-8 md:mt-0">
                    <label class="block text-[9px] uppercase font-black text-orange-900/40 tracking-[0.2em] mb-2 text-right">Devise d'affichage</label>
                    <div class="flex gap-2">
                        <template x-for="curr in Object.keys(rates)">
                            <button type="button" 
                                @click="currency = curr"
                                :class="currency === curr ? 'bg-orange-800 text-white' : 'bg-white text-gray-500 border-gray-100'"
                                class="px-3 py-1 text-[10px] font-bold border transition-all"
                                x-text="curr">
                            </button>
                        </template>
                    </div>
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
                                </div>

                                <div class="flex-1">
                                    <div class="flex justify-between items-baseline mb-6">
                                        <h3 class="font-serif text-3xl text-[#2D241E]" x-text="item.nom"></h3>
                                        <span class="h-px flex-1 mx-4 bg-orange-100"></span>
                                        <span class="font-bold text-orange-900 tracking-tighter text-xl" x-text="formatPrice(item.prix)"></span>
                                    </div>
                                    
                                    <input type="hidden" :name="'articles['+index+'][modele_id]'" :value="item.id">

                                    <div class="grid grid-cols-2 gap-8 mb-8">
                                        <div class="relative group/select">
                                            <label class="text-[9px] uppercase font-black text-orange-900/40 tracking-[0.2em] mb-2 block">Mesure standard</label>
                                            <select :name="'articles['+index+'][taille]'" x-model="item.taille" class="w-full border-0 border-b-2 border-orange-50 bg-transparent text-sm focus:ring-0 focus:border-[#2D241E] py-3 pl-0 appearance-none cursor-pointer">
                                                <option value="XS">XS — Smallest</option>
                                                <option value="S">S — Small</option>
                                                <option value="M">M — Medium</option>
                                                <option value="L">L — Large</option>
                                                <option value="XL">XL — Extra Large</option>
                                            </select>
                                        </div>
                                        <div class="relative">
                                            <label class="text-[9px] uppercase font-black text-orange-900/40 tracking-[0.2em] mb-2 block">Sélection Textile</label>
                                            <select :name="'articles['+index+'][tissu]'" class="w-full border-0 border-b-2 border-orange-50 bg-transparent text-sm focus:ring-0 focus:border-[#2D241E] py-3 pl-0 appearance-none cursor-pointer">
                                                <option>Coton Bio d'Afrique</option>
                                                <option>Soie Sauvage</option>
                                                <option>Lin Premium</option>
                                                <option>Bazin Riche</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="text-[9px] uppercase font-black text-orange-900/40 tracking-[0.2em] mb-2 block">Instructions particulières</label>
                                        <textarea :name="'articles['+index+'][commentaires]'" class="w-full border-0 bg-[#FDFDFD] text-sm italic focus:ring-0 focus:bg-white border-l-2 border-orange-100 focus:border-orange-800 p-4 transition-all resize-none" rows="2" placeholder="Ex: Longueur manche +2cm..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div class="lg:col-span-5">
                        <div class="bg-white p-12 shadow-[0_40px_100px_rgba(45,36,30,0.08)] border border-orange-100/50 sticky top-32 relative overflow-hidden">
                            <h2 class="font-serif text-3xl mb-10 text-[#2D241E]">Règlement</h2>
                            
                            <div class="space-y-10 relative z-10">
                                <div class="space-y-6">
                                    <div class="group">
                                        <label class="block text-[10px] uppercase font-bold text-gray-400 mb-4 tracking-widest text-center">Opérateur Mobile</label>
                                        <div class="grid grid-cols-3 gap-3">
                                            <label class="cursor-pointer">
                                                <input type="radio" name="operateur" value="mvola" class="hidden peer" required>
                                                <div class="text-[9px] font-bold text-center py-4 border border-gray-100 peer-checked:border-[#2D241E] peer-checked:bg-[#2D241E] peer-checked:text-white transition-all uppercase tracking-tighter">M-Vola</div>
                                            </label>
                                            <label class="cursor-pointer">
                                                <input type="radio" name="operateur" value="orange" class="hidden peer">
                                                <div class="text-[9px] font-bold text-center py-4 border border-gray-100 peer-checked:border-orange-600 peer-checked:bg-orange-600 peer-checked:text-white transition-all uppercase tracking-tighter">Orange</div>
                                            </label>
                                            <label class="cursor-pointer">
                                                <input type="radio" name="operateur" value="airtel" class="hidden peer">
                                                <div class="text-[9px] font-bold text-center py-4 border border-gray-100 peer-checked:border-red-600 peer-checked:bg-red-600 peer-checked:text-white transition-all uppercase tracking-tighter">Airtel</div>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="space-y-3">
                                        <label class="block text-[10px] uppercase font-bold text-gray-400 tracking-widest text-center">Référence Transaction</label>
                                        <input type="tel" name="telephone" required placeholder="03X XX XXX XX" class="w-full border-0 border-b-2 border-gray-100 bg-gray-50/30 py-4 text-center text-2xl tracking-[0.3em] focus:ring-0 focus:border-[#2D241E] focus:bg-white transition-all font-light placeholder:text-gray-200">
                                    </div>
                                </div>

                                <div class="pt-10 border-t border-orange-50 space-y-5">
                                    <div class="flex justify-between items-center text-[11px] uppercase tracking-widest text-gray-500">
                                        <span>Sous-total</span>
                                        <span class="font-bold text-[#2D241E]" x-text="formatPrice(items.reduce((sum, i) => sum + i.prix, 0))"></span>
                                    </div>
                                    <div class="flex justify-between items-center pt-6 border-t border-[#2D241E]/5">
                                        <span class="font-serif text-3xl italic text-[#2D241E]">Total</span>
                                        <span class="text-3xl font-bold text-[#2D241E] tracking-tighter" x-text="formatPrice(items.reduce((sum, i) => sum + i.prix, 0))"></span>
                                    </div>

                                    <button type="submit" class="w-full bg-[#2D241E] text-white py-7 rounded-none font-bold uppercase tracking-[0.3em] text-[12px] hover:bg-orange-800 transition-all duration-500 shadow-xl mt-8 flex items-center justify-center gap-4 group">
                                        <span>Confirmer la commande</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div x-show="submitted" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center bg-[#F9F7F4]/98 backdrop-blur-sm p-6">
            <div class="max-w-2xl w-full text-center">
                 <h2 class="font-serif text-6xl text-[#2D241E] mb-6 tracking-tight">Merci, <span class="italic">Manda</span></h2>
                 <p class="text-orange-800 uppercase tracking-[0.6em] text-[11px] mb-12 font-black">L'excellence prend forme</p>
            </div>
        </div>

    </div>
</div>
@endsection