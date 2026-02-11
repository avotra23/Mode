@extends('layouts.app')

@section('content')
<div class="bg-white min-h-screen pb-20" x-data="{ items: JSON.parse(localStorage.getItem('cart') || '[]') }">
    <div class="max-w-5xl mx-auto px-6 pt-32">
        <h1 class="text-4xl font-serif italic mb-2">Personnalisation de vos pièces</h1>
        <p class="text-gray-500 uppercase tracking-widest text-[10px] mb-12">Dernière étape avant la confection</p>

        <form action="{{ route('commande.store') }}" method="POST" id="orderForm">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <div class="lg:col-span-2 space-y-8">
                    <template x-for="(item, index) in items" :key="item.id">
                        <div class="border border-orange-100 p-6 flex gap-6 shadow-sm">
                            <img :src="item.image" class="w-32 h-44 object-cover">

                            <div class="flex-1 space-y-4">
                                <h3 class="font-serif text-xl" x-text="item.nom"></h3>
                                <input type="hidden" :name="'articles['+index+'][modele_id]'" :value="item.id">

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-[9px] uppercase font-bold text-gray-400 mb-1">Taille</label>
                                        <select :name="'articles['+index+'][taille]'" class="w-full border-gray-200 text-sm focus:ring-orange-700">
                                            <option>XS</option><option>S</option><option selected>M</option>
                                            <option>L</option><option>XL</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-[9px] uppercase font-bold text-gray-400 mb-1">Tissu</label>
                                        <select :name="'articles['+index+'][tissu]'" class="w-full border-gray-200 text-sm focus:ring-orange-700">
                                            <option>Coton Bio</option><option>Soie Sauvage</option><option>Lin</option>
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-[9px] uppercase font-bold text-gray-400 mb-1">Notes (Mesures, couleur spécifique...)</label>
                                    <textarea :name="'articles['+index+'][commentaires]'" class="w-full border-gray-200 text-sm italic" rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="bg-gray-50 p-8 h-fit border border-orange-100">
                    <h2 class="font-serif text-2xl mb-6 italic text-[#2D241E]">Règlement</h2>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-[9px] uppercase font-bold text-gray-400 mb-2">Opérateur</label>
                            <select name="operateur" required class="w-full border-gray-200">
                                <option value="mvola">M-Vola (Telma)</option>
                                <option value="orange">Orange Money</option>
                                <option value="airtel">Airtel Money</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-[9px] uppercase font-bold text-gray-400 mb-2">Numéro de téléphone</label>
                            <input type="tel" name="telephone" required placeholder="034 00 000 00"
                                   class="w-full border-gray-200 py-3 text-lg tracking-widest">
                        </div>

                        <div class="pt-6 border-t border-gray-200">
                            <div class="flex justify-between text-xl font-serif mb-8">
                                <span>Total</span>
                                <span class="font-bold text-orange-700" x-text="items.reduce((sum, i) => sum + i.prix, 0).toLocaleString() + ' FCFA'"></span>
                            </div>

                            <button type="submit" @click="localStorage.removeItem('cart')"
                                    class="w-full bg-[#2D241E] text-white py-4 font-bold uppercase tracking-widest text-xs hover:bg-black transition-all">
                                Confirmer la Commande
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
