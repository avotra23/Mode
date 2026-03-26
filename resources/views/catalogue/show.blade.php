@extends('layouts.app')

@section('content')

{{-- ========== FIL D'ARIANE ========== --}}
<div class="bg-[#FDFBF7] border-b border-orange-50">
    <div class="max-w-7xl mx-auto px-6 lg:px-12 py-5">
        <nav class="flex items-center gap-2 text-[10px] uppercase tracking-[0.3em]">
            <a href="{{ route('catalogue.index') }}" class="text-gray-400 hover:text-orange-700 transition-colors">Catalogue</a>
            <span class="text-orange-200">/</span>
            @if($modele->collection)
            <a href="{{ route('catalogue.index', ['collection' => $modele->collection->id]) }}" class="text-gray-400 hover:text-orange-700 transition-colors">{{ $modele->collection->nom }}</a>
            <span class="text-orange-200">/</span>
            @endif
            <span class="text-orange-700 font-bold">{{ $modele->nom }}</span>
        </nav>
    </div>
</div>

{{-- ========== CONTENU PRINCIPAL ========== --}}
<div class="bg-[#FDFBF7] min-h-screen">
    <div class="max-w-7xl mx-auto px-6 lg:px-12 py-12 lg:py-20"
         x-data="{
            selectedSize: '',
            selectedStock: null,
            activeImage: 0,
            // --- NOUVELLES DONNÉES ---
            basePrice: {{ $modele->prix_base }},
            currency: 'FCFA',
            rates: {
                'FCFA': 1,
                'EUR': 0.0015,     // Exemple: 1 FCFA = 0.0015 €
                'USD': 0.0016,     // Exemple: 1 FCFA = 0.0016 $
                'MGA': 7.5         // Exemple: 1 FCFA = 7.5 Ar
            },
            get convertedPrice() {
                let price = this.basePrice * this.rates[this.currency];
                return new Intl.NumberFormat('fr-FR').format(Math.round(price));
            },
            zoom: false,
            zoomX: 0,
            zoomY: 0,
            images: {{ json_encode($modele->images ?? []) }},
            handleMouseMove(e) {
                if (!this.zoom) return;
                const rect = e.target.getBoundingClientRect();
                this.zoomX = ((e.clientX - rect.left) / rect.width) * 100;
                this.zoomY = ((e.clientY - rect.top) / rect.height) * 100;
            }
         }">

        <div class="flex flex-col lg:flex-row gap-12 xl:gap-20 items-start">

            {{-- ======== COLONNE GAUCHE : GALERIE ======== --}}
            <div class="w-full lg:w-[55%] reveal-up" style="animation-delay:0.1s">

                {{-- Image principale avec zoom --}}
                <div class="relative overflow-hidden bg-[#1A110C] group cursor-zoom-in mb-4"
                     @mouseenter="zoom = true"
                     @mouseleave="zoom = false"
                     @mousemove="handleMouseMove($event)">

                    <div class="aspect-[3/4]">
                        @if($modele->images && count($modele->images) > 0)
                        <template x-for="(img, i) in images" :key="i">
                            <img :src="'{{ asset('storage/') }}/' + img"
                                 alt="{{ $modele->nom }}"
                                 x-show="activeImage === i"
                                 :style="zoom ? `transform-origin: ${zoomX}% ${zoomY}%; transform: scale(1.8)` : 'transform: scale(1)'"
                                 class="w-full h-full object-cover transition-transform duration-300 ease-out absolute inset-0">
                        </template>
                        @else
                        <img src="https://images.unsplash.com/photo-1539109136881-3be0616acf4b?q=80&w=800"
                             alt="{{ $modele->nom }}"
                             :style="zoom ? `transform-origin: ${zoomX}% ${zoomY}%; transform: scale(1.8)` : 'transform: scale(1)'"
                             class="w-full h-full object-cover transition-transform duration-300 ease-out">
                        @endif
                    </div>

                    {{-- Overlay d'info zoom --}}
                    <div class="absolute bottom-4 right-4 bg-black/50 backdrop-blur-sm text-white text-[9px] uppercase tracking-widest px-3 py-1.5 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <i class="fa-solid fa-magnifying-glass mr-2 text-[8px]"></i>Survoler pour zoomer
                    </div>

                    {{-- Badge Collection --}}
                    <div class="absolute top-4 left-4 bg-orange-700 text-white text-[9px] font-black uppercase tracking-[0.4em] px-4 py-2">
                        {{ $modele->collection->nom ?? 'Exclusive' }}
                    </div>

                    {{-- Numéro de pièce --}}
                    <div class="absolute top-4 right-4 font-serif italic text-white/20 text-5xl select-none pointer-events-none">
                        No.{{ str_pad($modele->id, 3, '0', STR_PAD_LEFT) }}
                    </div>
                </div>

                {{-- Miniatures --}}
                @if($modele->images && count($modele->images) > 1)
                <div class="grid grid-cols-4 gap-3">
                    @foreach($modele->images as $i => $img)
                    <button @click="activeImage = {{ $i }}"
                            :class="activeImage === {{ $i }} ? 'ring-2 ring-orange-700 ring-offset-2' : 'ring-1 ring-transparent hover:ring-orange-200'"
                            class="aspect-square overflow-hidden bg-gray-100 transition-all duration-300">
                        <img src="{{ asset('storage/' . $img) }}"
                             alt="{{ $modele->nom }} - vue {{ $i + 1 }}"
                             class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                    </button>
                    @endforeach
                </div>
                @endif

                {{-- Indicateurs mobiles (dots) --}}
                @if($modele->images && count($modele->images) > 1)
                <div class="flex justify-center gap-2 mt-4 md:hidden">
                    @foreach($modele->images as $i => $img)
                    <button @click="activeImage = {{ $i }}"
                            :class="activeImage === {{ $i }} ? 'w-6 bg-orange-700' : 'w-2 bg-gray-300'"
                            class="h-2 rounded-full transition-all duration-300"></button>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- ======== COLONNE DROITE : DÉTAILS ======== --}}
            <div class="w-full lg:w-[45%] lg:sticky lg:top-28 reveal-up" style="animation-delay:0.25s">

                {{-- En-tête produit --}}
                <div class="mb-8">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="h-px w-8 bg-orange-600"></div>
                        <span class="text-orange-700 font-bold uppercase tracking-[0.4em] text-[10px]">
                            {{ $modele->collection->nom ?? 'Collection Exclusive' }}
                        </span>
                    </div>
                    <h1 class="font-serif italic text-[#2D241E] leading-tight mb-4" style="font-size:clamp(2rem,5vw,3.5rem)">
                        {{ $modele->nom }}
                    </h1>

                    {{-- Prix et Sélecteur de Devise --}}
                    <div class="flex flex-col gap-2">
                        <div class="flex items-baseline gap-3">
                            <span class="text-4xl font-light text-[#2D241E]" x-text="convertedPrice"></span>
                            <span class="text-sm text-gray-400 uppercase tracking-widest" x-text="currency"></span>
                        </div>
                        
                        {{-- Sélecteur de devise style minimaliste --}}
                        <div class="flex gap-3 mt-1">
                            <template x-for="curr in ['FCFA', 'EUR', 'USD', 'MGA']">
                                <button @click="currency = curr" 
                                        :class="currency === curr ? 'text-orange-700 font-bold border-b-2 border-orange-700' : 'text-gray-400 hover:text-gray-600'"
                                        class="text-[10px] uppercase tracking-tighter pb-1 transition-all" 
                                        x-text="curr">
                                </button>
                            </template>
                        </div>
                    </div>

                    {{-- Note moyenne (déco) --}}
                    <div class="flex items-center gap-2 mt-3">
                        <div class="flex gap-0.5">
                            @for($s = 0; $s < 5; $s++)
                            <span class="text-orange-400 text-sm">★</span>
                            @endfor
                        </div>
                        <span class="text-[10px] text-gray-400 uppercase tracking-widest">Pièce Artisanale Certifiée</span>
                    </div>
                </div>

                <div class="h-px bg-orange-100 mb-8"></div>

                {{-- ---- SÉLECTION DE TAILLE ---- --}}
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-5">
                        <h4 class="text-[#2D241E] font-black uppercase text-[10px] tracking-[0.3em]">Choisir une taille</h4>
                        <button class="text-[10px] text-orange-600 hover:text-orange-800 transition-colors uppercase tracking-widest border-b border-orange-200 hover:border-orange-600 pb-0.5">
                            Guide des tailles
                        </button>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        @foreach($modele->options as $option)
                        @php
                            $stock = $option->pivot->stock;
                            $isLow = ($stock > 0 && $stock <= 3);
                        @endphp
                        <button
                            @click="selectedSize = '{{ $option->valeur }}'; selectedStock = {{ $stock }}"
                            {{ $stock <= 0 ? 'disabled' : '' }}
                            :class="selectedSize === '{{ $option->valeur }}'
                                ? 'border-[#2D241E] bg-[#2D241E] text-white shadow-lg scale-[1.02]'
                                : 'border-orange-100 bg-white text-[#2D241E] hover:border-orange-400 hover:shadow-md'"
                            class="relative flex flex-col items-center justify-center border-2 py-4 px-3 transition-all duration-300 rounded-sm group/size {{ $stock <= 0 ? 'opacity-30 cursor-not-allowed' : 'cursor-pointer' }}">

                            <span class="text-sm font-black tracking-widest uppercase mb-1.5">{{ $option->valeur }}</span>

                            @if($stock > 0)
                            <span :class="selectedSize === '{{ $option->valeur }}' ? 'bg-orange-600/30 text-orange-200' : '{{ $isLow ? 'bg-orange-100 text-orange-700' : 'bg-green-50 text-green-600' }}'"
                                  class="text-[8px] px-2 py-0.5 rounded-full uppercase font-bold tracking-tight transition-colors">
                                {{ $stock }} en stock{{ $isLow ? ' ⚡' : '' }}
                            </span>
                            @else
                            <span class="text-[8px] px-2 py-0.5 bg-gray-100 text-gray-400 uppercase font-bold rounded-full">Épuisé</span>
                            @endif
                        </button>
                        @endforeach
                    </div>

                    {{-- Alerte stock faible --}}
                    <template x-if="selectedStock > 0 && selectedStock <= 3">
                        <div class="mt-4 flex items-center gap-3 bg-orange-50 border border-orange-200 px-4 py-3 rounded-sm">
                            <i class="fa-solid fa-fire-flame-curved text-orange-600 text-sm"></i>
                            <span class="text-[10px] font-bold uppercase tracking-wide text-orange-700">
                                Pièce rare — plus que <span x-text="selectedStock"></span> exemplaire(s) disponible(s) !
                            </span>
                        </div>
                    </template>
                </div>

                {{-- ---- BOUTONS D'ACTION ---- --}}
                <div class="space-y-3 mb-10">
                    {{-- Ajouter au panier --}}
                    <button
                        @click="if(!selectedSize) {
                            // Petite animation de shake si pas de taille
                            $el.closest('div').querySelector('.size-grid').classList.add('shake');
                            setTimeout(() => $el.closest('div').querySelector('.size-grid')?.classList.remove('shake'), 600);
                            return;
                        }
                        $dispatch('add-to-cart', {
                            id: {{ $modele->id }},
                            nom: '{{ addslashes($modele->nom) }}',
                            taille: selectedSize,
                            prix: {{ $modele->prix_base }},
                            devise: currency,
                            image: '{{ ($modele->images && count($modele->images) > 0) ? asset('storage/'.$modele->images[0]) : '' }}'
                        })"
                        :class="selectedSize ? 'bg-[#1A110C] hover:bg-black shadow-xl shadow-[#1A110C]/20' : 'bg-[#2D241E]/70 cursor-not-allowed'"
                        class="w-full text-white py-5 px-8 font-black uppercase tracking-[0.3em] text-[11px] flex justify-between items-center group transition-all duration-300">
                        <span x-text="selectedSize ? 'Ajouter à ma sélection' : 'Choisir une taille d\'abord'"></span>
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-bag-shopping text-orange-400 text-sm group-hover:scale-110 transition-transform"></i>
                            <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                        </div>
                    </button>

                    {{-- Wishlist --}}
                    <button class="w-full border-2 border-orange-100 text-gray-400 hover:border-orange-300 hover:text-orange-700 py-4 px-8 font-bold uppercase tracking-[0.25em] text-[10px] flex justify-center items-center gap-3 transition-all duration-300 group">
                        <i class="fa-regular fa-heart group-hover:fa-solid transition-all"></i>
                        Sauvegarder dans mes favoris
                    </button>
                </div>

                {{-- ---- DESCRIPTION STYLISTE ---- --}}
                <div class="bg-[#2D241E]/[0.03] border border-orange-100 p-6 mb-8 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-1 h-full bg-orange-600"></div>
                    <h4 class="text-[#2D241E] font-black uppercase text-[10px] tracking-[0.3em] mb-3 flex items-center gap-2">
                        <span>✂️</span> Note du Styliste
                    </h4>
                    <p class="text-gray-600 text-sm font-serif italic leading-relaxed">
                        "{{ $modele->description ?? 'Une création exclusive qui allie la noblesse des tissus africains à la précision du geste artisanal. Chaque point est posé avec intention.' }}"
                    </p>
                </div>

                {{-- ---- GARANTIES ---- --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-8">
                    @foreach([
                        ['icon' => 'fa-truck', 'title' => 'Livraison offerte', 'sub' => 'À domicile'],
                        ['icon' => 'fa-scissors', 'title' => 'Retouche possible', 'sub' => 'En atelier'],
                        ['icon' => 'fa-shield-halved', 'title' => 'Authenticité', 'sub' => '100% garantie'],
                    ] as $g)
                    <div class="flex flex-col items-center text-center p-4 border border-orange-50 hover:border-orange-200 transition-colors duration-300">
                        <i class="fa-solid {{ $g['icon'] }} text-orange-600 text-lg mb-2"></i>
                        <span class="text-[#2D241E] font-bold text-[10px] uppercase tracking-widest">{{ $g['title'] }}</span>
                        <span class="text-gray-400 text-[9px] mt-0.5">{{ $g['sub'] }}</span>
                    </div>
                    @endforeach
                </div>

                {{-- ---- PARTAGE ---- --}}
                <div class="flex items-center justify-between pt-6 border-t border-orange-50">
                    <span class="text-[9px] font-bold uppercase text-gray-400 tracking-[0.3em]">Partager</span>
                    <div class="flex gap-4">
                        @foreach(['fa-brands fa-instagram' => '#', 'fa-brands fa-whatsapp' => '#', 'fa-brands fa-pinterest' => '#', 'fa-solid fa-link' => '#'] as $icon => $link)
                        <a href="{{ $link }}" class="w-8 h-8 border border-orange-100 hover:border-orange-400 hover:bg-orange-50 flex items-center justify-center text-gray-400 hover:text-orange-700 transition-all duration-300 rounded-sm text-xs">
                            <i class="{{ $icon }}"></i>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- ========== SECTION DÉTAILS PRODUIT ========== --}}
        <div class="mt-24 pt-16 border-t border-orange-100">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10" x-data="{ activeTab: 'details' }">

                {{-- Onglets --}}
                <div class="md:col-span-3">
                    <div class="flex gap-0 border-b border-orange-100 overflow-x-auto">
                        @foreach(['details' => 'Détails de la pièce', 'care' => 'Entretien', 'livraison' => 'Livraison & Retour'] as $tab => $label)
                        <button @click="activeTab = '{{ $tab }}'"
                                :class="activeTab === '{{ $tab }}' ? 'border-b-2 border-orange-700 text-orange-700 font-black' : 'text-gray-400 hover:text-gray-700'"
                                class="text-[10px] uppercase tracking-[0.3em] font-bold px-8 py-5 transition-all duration-300 whitespace-nowrap flex-shrink-0">
                            {{ $label }}
                        </button>
                        @endforeach
                    </div>
                </div>

                {{-- Contenu onglets --}}
                <div class="md:col-span-3 py-8">
                    <div x-show="activeTab === 'details'" class="grid grid-cols-1 md:grid-cols-2 gap-12">
                        <div>
                            <h4 class="font-bold text-[#2D241E] uppercase tracking-widest text-[10px] mb-6">Composition & Matière</h4>
                            <ul class="space-y-4 text-sm text-gray-600">
                                <li class="flex justify-between pb-3 border-b border-orange-50">
                                    <span class="text-gray-400 text-[10px] uppercase tracking-widest">Matière principale</span>
                                    <span class="font-bold text-[#2D241E] text-[10px] uppercase">Wax 100% coton</span>
                                </li>
                                <li class="flex justify-between pb-3 border-b border-orange-50">
                                    <span class="text-gray-400 text-[10px] uppercase tracking-widest">Doublure</span>
                                    <span class="font-bold text-[#2D241E] text-[10px] uppercase">Viscose légère</span>
                                </li>
                                <li class="flex justify-between pb-3 border-b border-orange-50">
                                    <span class="text-gray-400 text-[10px] uppercase tracking-widest">Origine tissu</span>
                                    <span class="font-bold text-[#2D241E] text-[10px] uppercase">Afrique de l'Ouest</span>
                                </li>
                                <li class="flex justify-between">
                                    <span class="text-gray-400 text-[10px] uppercase tracking-widest">Confection</span>
                                    <span class="font-bold text-[#2D241E] text-[10px] uppercase">Atelier local</span>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-bold text-[#2D241E] uppercase tracking-widest text-[10px] mb-6">Informations</h4>
                            <ul class="space-y-4">
                                <li class="flex items-start gap-3 text-sm text-gray-600">
                                    <span class="w-1.5 h-1.5 bg-orange-600 rounded-full mt-1.5 flex-shrink-0"></span>
                                    Pièce confectionnée artisanalement, de légères variations sont possibles et font partie de l'authenticité de la pièce.
                                </li>
                                <li class="flex items-start gap-3 text-sm text-gray-600">
                                    <span class="w-1.5 h-1.5 bg-orange-600 rounded-full mt-1.5 flex-shrink-0"></span>
                                    Les couleurs peuvent légèrement varier selon l'écran de visualisation.
                                </li>
                                <li class="flex items-start gap-3 text-sm text-gray-600">
                                    <span class="w-1.5 h-1.5 bg-orange-600 rounded-full mt-1.5 flex-shrink-0"></span>
                                    Référence : <span class="font-bold text-[#2D241E]">ASS-{{ str_pad($modele->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div x-show="activeTab === 'care'" class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @foreach([
                            ['icon' => '🫧', 'title' => 'Lavage', 'text' => 'Lavage à la main à l\'eau froide ou à 30°C en machine, programme délicat.'],
                            ['icon' => '♨️', 'title' => 'Repassage', 'text' => 'Repasser à température moyenne sur l\'envers de la pièce.'],
                            ['icon' => '🚫', 'title' => 'À éviter', 'text' => 'Ne pas mettre en sécheuse. Ne pas utiliser de javel ou agents blanchissants.'],
                            ['icon' => '👗', 'title' => 'Rangement', 'text' => 'Ranger sur cintre ou plié dans un endroit aéré, à l\'abri de la lumière directe.'],
                        ] as $care)
                        <div class="flex gap-4 p-5 border border-orange-50 hover:border-orange-200 transition-colors">
                            <span class="text-2xl flex-shrink-0">{{ $care['icon'] }}</span>
                            <div>
                                <h5 class="font-black text-[#2D241E] text-[10px] uppercase tracking-widest mb-2">{{ $care['title'] }}</h5>
                                <p class="text-gray-500 text-xs leading-relaxed">{{ $care['text'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div x-show="activeTab === 'livraison'" class="max-w-2xl">
                        <div class="space-y-6">
                            @foreach([
                                ['icon' => 'fa-truck', 'title' => 'Livraison standard — Gratuite', 'text' => 'Livraison à domicile sous 3 à 5 jours ouvrables dans les principales villes.'],
                                ['icon' => 'fa-bolt', 'title' => 'Livraison express — 2 000 FCFA', 'text' => 'Livraison en 24h pour Antananarivo et les zones proches de l\'atelier.'],
                                ['icon' => 'fa-rotate-left', 'title' => 'Retours — 7 jours', 'text' => 'Retour accepté dans les 7 jours suivant la réception, pièce non portée et dans son état d\'origine.'],
                            ] as $liv)
                            <div class="flex gap-5 p-6 border border-orange-50 hover:border-orange-200 transition-colors">
                                <div class="w-10 h-10 bg-orange-50 flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid {{ $liv['icon'] }} text-orange-600 text-sm"></i>
                                </div>
                                <div>
                                    <h5 class="font-black text-[#2D241E] text-[10px] uppercase tracking-widest mb-2">{{ $liv['title'] }}</h5>
                                    <p class="text-gray-500 text-sm leading-relaxed">{{ $liv['text'] }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ========== VOUS AIMEREZ AUSSI ========== --}}
        {{-- Section dynamique - à connecter avec $similarModeles si disponible --}}
        <div class="mt-20 pt-16 border-t border-orange-100">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <span class="text-orange-700 font-bold uppercase tracking-[0.4em] text-[10px] block mb-3">De la même collection</span>
                    <h3 class="font-serif italic text-[#2D241E] text-4xl">Vous aimerez aussi</h3>
                </div>
                <a href="{{ route('catalogue.index') }}" class="hidden md:flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-gray-400 hover:text-orange-700 transition-colors group">
                    Tout voir
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            {{-- Placeholder cards si pas de modèles similaires --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                @if(isset($similaires) && $similaires->count() > 0)
                    @foreach($similaires->take(4) as $sim)
                    <a href="{{ route('catalogue.show', $sim->id) }}" class="group block">
                        <div class="aspect-[3/4] overflow-hidden bg-gray-100 mb-4">
                            @if($sim->images && count($sim->images) > 0)
                            <img src="{{ asset('storage/' . $sim->images[0]) }}" alt="{{ $sim->nom }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @endif
                        </div>
                        <span class="text-[10px] text-orange-600 font-bold uppercase tracking-widest block mb-1">{{ $sim->collection->nom ?? '' }}</span>
                        <h4 class="font-serif italic text-[#2D241E] text-lg">{{ $sim->nom }}</h4>
                        <p class="text-gray-500 text-sm mt-1">{{ number_format($sim->prix_base, 0, ',', ' ') }} FCFA</p>
                    </a>
                    @endforeach
                @else
                    @for($p = 0; $p < 4; $p++)
                    <div class="group block">
                        <div class="aspect-[3/4] overflow-hidden bg-gradient-to-br from-orange-50 to-orange-100/50 mb-4 flex items-center justify-center">
                            <span class="font-serif italic text-orange-200 text-4xl">A</span>
                        </div>
                        <div class="h-2 w-16 bg-orange-100 rounded mb-2"></div>
                        <div class="h-4 w-32 bg-gray-100 rounded"></div>
                    </div>
                    @endfor
                @endif
            </div>
        </div>
    </div>
</div>

{{-- ========== STYLES ========== --}}
<style>
.reveal-up {
    opacity: 0;
    transform: translateY(30px);
    animation: revealUp 0.9s cubic-bezier(0.22,1,0.36,1) forwards;
}
@keyframes revealUp { to { opacity:1; transform:translateY(0); } }

@keyframes shake {
    0%,100% { transform: translateX(0); }
    20% { transform: translateX(-6px); }
    40% { transform: translateX(6px); }
    60% { transform: translateX(-4px); }
    80% { transform: translateX(4px); }
}
.shake { animation: shake 0.5s ease-in-out; }

[x-cloak] { display: none !important; }

@media (max-width: 768px) {
    .lg\:sticky { position: relative; top: auto; }
}
</style>

@endsection