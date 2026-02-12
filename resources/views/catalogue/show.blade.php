@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 lg:px-12 py-12">
    {{-- Fil d'Ariane --}}
    <nav class="mb-12 text-[10px] uppercase tracking-[0.2em] flex items-center gap-2">
        <a href="{{ route('catalogue.index') }}" class="text-gray-400 hover:text-black transition">Catalogue</a>
        <span class="text-gray-300">/</span>
        <span class="text-orange-700 font-bold">{{ $modele->nom }}</span>
    </nav>

    <div class="flex flex-col lg:flex-row gap-16 items-start">
        {{-- Galerie d'images (Gauche) --}}
        <div class="w-full lg:w-3/5">
            <div class="grid grid-cols-1 gap-8">
                @if($modele->images && count($modele->images) > 0)
                    @foreach($modele->images as $img)
                        <div class="overflow-hidden bg-gray-50 rounded-sm">
                            <img src="{{ asset('storage/' . $img) }}"
                                 alt="{{ $modele->nom }}"
                                 class="w-full h-auto object-cover shadow-sm hover:scale-[1.02] transition-transform duration-700">
                        </div>
                    @endforeach
                @else
                    <div class="aspect-[3/4] bg-gray-100 flex items-center justify-center text-gray-400 uppercase text-[10px] tracking-widest">
                        Image non disponible
                    </div>
                @endif
            </div>
        </div>

        {{-- Détails et Achat (Droite - Collant au scroll) --}}
        <div class="w-full lg:w-2/5 lg:sticky lg:top-32" x-data="{ selectedSize: '', selectedStock: null }">
            <div class="mb-10">
                <span class="text-orange-700 font-bold uppercase tracking-[0.3em] text-[10px] block mb-2">
                    {{ $modele->collection->nom ?? 'Collection Exclusive' }}
                </span>
                <h1 class="text-5xl font-serif italic mb-4 leading-tight text-gray-900">{{ $modele->nom }}</h1>
                <div class="text-3xl font-light text-gray-800">
                    {{ number_format($modele->prix_base, 0, ',', ' ') }} <span class="text-sm">FCFA</span>
                </div>
            </div>

            <hr class="border-gray-100 mb-10">

            {{-- SECTION TAILLES & STOCKS (Haute Visibilité) --}}
            <div class="mb-10">
                <div class="flex justify-between items-end mb-6">
                    <h4 class="text-black font-bold uppercase text-[10px] tracking-[0.2em]">Choisir une taille</h4>
                    <span class="text-[10px] text-gray-400 italic" x-show="selectedSize">
                        Taille sélectionnée : <span class="text-black font-bold" x-text="selectedSize"></span>
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    @foreach($modele->options as $option)
                        @php
                            $stock = $option->pivot->stock;
                            $isLowStock = ($stock > 0 && $stock <= 3);
                        @endphp
                        <button
                            @click="selectedSize = '{{ $option->valeur }}'; selectedStock = {{ $stock }}"
                            {{ $stock <= 0 ? 'disabled' : '' }}
                            :class="selectedSize === '{{ $option->valeur }}' ? 'border-black bg-black text-white shadow-xl scale-[1.02]' : 'border-gray-200 bg-white text-gray-800 hover:border-orange-400'"
                            class="relative flex flex-col items-center justify-center border py-5 px-4 transition-all duration-300 rounded-sm {{ $stock <= 0 ? 'opacity-30 cursor-not-allowed bg-gray-50' : '' }}"
                        >
                            <span class="text-sm font-bold tracking-widest uppercase">{{ $option->valeur }}</span>

                            @if($stock > 0)
                                <span class="mt-2 text-[9px] px-2 py-0.5 rounded-full uppercase tracking-tighter {{ $isLowStock ? 'bg-orange-100 text-orange-700 font-bold' : 'bg-green-50 text-green-700' }}">
                                    {{ $stock }} en stock
                                </span>
                            @else
                                <span class="mt-2 text-[9px] px-2 py-0.5 bg-gray-100 text-gray-400 uppercase tracking-tighter">
                                    Épuisé
                                </span>
                            @endif
                        </button>
                    @endforeach
                </div>

                {{-- Alerte stock faible dynamique --}}
                <template x-if="selectedStock > 0 && selectedStock <= 3">
                    <div class="mt-4 flex items-center gap-2 text-orange-700 animate-pulse bg-orange-50 p-3 rounded-sm">
                        <i class="fa-solid fa-fire-flame-curved text-xs"></i>
                        <span class="text-[10px] font-bold uppercase tracking-wide">Attention : Pièce rare, stock presque épuisé !</span>
                    </div>
                </template>
            </div>

            {{-- Description --}}
            <div class="space-y-6 text-gray-600 leading-relaxed mb-10">
                <div class="group">
                    <h4 class="text-black font-bold uppercase text-[10px] tracking-widest mb-3 italic">Note du Styliste</h4>
                    <p class="text-sm font-serif italic border-l-2 border-orange-100 pl-4">
                        {{ $modele->description ?? 'Une création exclusive alliant noblesse des tissus et précision du geste.' }}
                    </p>
                </div>

                <ul class="text-[10px] space-y-3 pt-4 border-t border-gray-50">
                    <li class="flex items-center gap-3"><span class="w-1 h-1 bg-orange-700"></span> 100% Confection Artisanale</li>
                    <li class="flex items-center gap-3"><span class="w-1 h-1 bg-orange-700"></span> Livraison offerte à domicile</li>
                    <li class="flex items-center gap-3"><span class="w-1 h-1 bg-orange-700"></span> Retouche sur mesure possible en atelier</li>
                </ul>
            </div>

            {{-- Boutons d'Action --}}
            <div class="space-y-4">
                <button
                    @click="if(!selectedSize) { alert('Veuillez sélectionner votre taille'); return; }
                    $dispatch('add-to-cart', {
                        id: {{ $modele->id }},
                        nom: '{{ $modele->nom }}',
                        taille: selectedSize,
                        prix: {{ $modele->prix_base }},
                        image: '{{ ($modele->images && count($modele->images) > 0) ? asset('storage/'.$modele->images[0]) : '' }}'
                    })"
                    class="w-full bg-[#1a1a1a] text-white py-6 px-8 font-bold uppercase tracking-[0.3em] text-[11px] hover:bg-black transition-all flex justify-between items-center group shadow-2xl"
                    :class="!selectedSize ? 'cursor-not-allowed opacity-90' : ''"
                >
                    <span x-text="selectedSize ? 'Ajouter à la commande' : 'Sélectionner une taille'"></span>
                    <i class="fa-solid fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                </button>

                <button class="w-full border border-gray-200 text-gray-400 py-5 px-8 font-bold uppercase tracking-[0.2em] text-[10px] hover:bg-gray-50 hover:text-black transition-all">
                    Guide des mesures
                </button>
            </div>

            {{-- Partage --}}
            <div class="mt-12 pt-8 border-t border-gray-50 flex items-center justify-between">
                <span class="text-[9px] font-bold uppercase text-gray-400 tracking-[0.2em]">Partager la pièce</span>
                <div class="flex gap-6 text-gray-400">
                    <a href="#" class="hover:text-black transition"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="hover:text-black transition"><i class="fa-brands fa-whatsapp"></i></a>
                    <a href="#" class="hover:text-black transition"><i class="fa-brands fa-pinterest"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
