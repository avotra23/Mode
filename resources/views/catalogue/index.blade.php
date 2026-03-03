@extends('layouts.app')

@section('content')
<div class="bg-[#FDFCFB] min-h-screen">
    <div class="max-w-7xl mx-auto px-6 lg:px-12 py-20">
        
        {{-- En-tête de prestige --}}
        <div class="relative mb-24 overflow-hidden py-10">
            <div class="flex flex-col md:flex-row justify-between items-center gap-10 relative z-10">
                <div class="text-center md:text-left">
                    <span class="text-orange-700 font-bold uppercase tracking-[0.5em] text-[10px] mb-4 block">Maison de Couture</span>
                    <h1 class="text-7xl md:text-8xl font-serif italic text-[#2D241E] leading-none">Ma Mode</h1>
                </div>
                <div class="hidden md:block w-px h-32 bg-orange-200"></div>
                <div class="max-w-xs text-right hidden md:block">
                    <p class="text-gray-400 text-sm italic leading-relaxed">
                        "L'élégance n'est pas de se faire remarquer, mais de se faire retenir."
                    </p>
                </div>
            </div>
            {{-- Filigrane en arrière-plan --}}
            <span class="absolute -bottom-10 -left-10 text-[12rem] font-serif italic text-orange-50/50 pointer-events-none select-none">Est. 2026</span>
        </div>

        {{-- Grille Artistique --}}
        <div class="grid grid-cols-1 md:grid-cols-12 gap-10 items-start">
            @foreach($modeles as $index => $modele)
                @php
                    $imagePath = ($modele->images && count($modele->images) > 0) ? $modele->images[0] : null;
                    
                    // Logique de mise en page alternée :
                    // 1er : Large (col-8), 2ème : Petit décalé (col-4), 3ème : Normal décalé bas (col-6)...
                    $colSpan = ($index % 5 == 0) ? 'md:col-span-8' : (($index % 5 == 1) ? 'md:col-span-4 mt-20' : 'md:col-span-6');
                    $aspectRatio = ($index % 5 == 0) ? 'aspect-video' : 'aspect-[3/4]';
                @endphp

                <div class="{{ $colSpan }} group" 
                     data-aos="fade-up" 
                     data-aos-delay="{{ ($index % 3) * 100 }}">
                    
                    <div class="relative overflow-hidden {{ $aspectRatio }} bg-stone-100 shadow-2xl transition-all duration-700 group-hover:shadow-orange-900/10">
                        
                        {{-- Image avec effet de parallaxe --}}
                        <img src="{{ $imagePath ? asset('storage/' . $imagePath) : 'https://images.unsplash.com/photo-1539109136881-3be0616acf4b?q=80&w=800' }}"
                             alt="{{ $modele->nom }}"
                             class="object-cover w-full h-full transition-transform duration-[1.5s] ease-out group-hover:scale-110">

                        {{-- Overlay Minimaliste --}}
                        <div class="absolute inset-0 bg-[#2D241E]/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-center items-center p-10">
                            <div class="h-px w-0 group-hover:w-20 bg-white transition-all duration-700 mb-4"></div>
                            <a href="{{ route('catalogue.show', $modele->id) }}" 
                               class="text-white text-[10px] uppercase tracking-[0.3em] font-bold">
                                Découvrir la pièce
                            </a>
                            <div class="h-px w-0 group-hover:w-20 bg-white transition-all duration-700 mt-4"></div>
                        </div>

                        {{-- Badge Prix flottant --}}
                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-4 py-2 opacity-0 group-hover:opacity-100 transition-all duration-500 transform translate-y-2 group-hover:translate-y-0">
                            <span class="text-[10px] font-bold text-[#2D241E]">{{ number_format($modele->prix_base, 0, ',', ' ') }} FCFA</span>
                        </div>
                    </div>

                    <div class="mt-8 {{ ($index % 5 == 0) ? 'max-w-md' : '' }}">
                        <p class="text-[9px] uppercase tracking-[0.4em] text-orange-800 font-bold mb-2">
                             {{ $modele->collection->nom ?? 'Signature 2026' }}
                        </p>
                        <h3 class="text-3xl font-serif italic text-[#2D241E] mb-2">{{ $modele->nom }}</h3>
                        <div class="w-10 h-[2px] bg-orange-100 group-hover:w-full transition-all duration-700"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Scripts d'animation --}}
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 1000,
        once: true,
        offset: 100
    });
</script>

<style>
    /* Empêcher le scroll horizontal pendant les animations */
    body { overflow-x: hidden; }
    
    .font-serif {
        font-family: 'Playfair Display', serif;
    }
</style>
@endsection