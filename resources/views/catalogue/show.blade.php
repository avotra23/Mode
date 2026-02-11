@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 lg:px-12 py-12">
    <nav class="mb-12 text-xs uppercase tracking-widest flex items-center gap-2">
        <a href="{{ route('catalogue.index') }}" class="text-gray-400 hover:text-black">Catalogue</a>
        <span class="text-gray-300">/</span>
        <span class="text-orange-700 font-bold">{{ $modele->nom }}</span>
    </nav>

    <div class="flex flex-col lg:flex-row gap-16 items-start">
        <div class="w-full lg:w-3/5">
            <div class="grid grid-cols-1 gap-4">
                <img src="{{ $modele->images[0] }}" alt="{{ $modele->nom }}" class="w-full rounded-sm shadow-2xl">
            </div>
        </div>

        <div class="w-full lg:w-2/5 lg:sticky lg:top-32">
            <h1 class="text-4xl font-serif italic mb-2 leading-tight">{{ $modele->nom }}</h1>
            <p class="text-orange-700 font-bold uppercase tracking-widest text-sm mb-6">{{ $modele->collection->nom }}</p>

            <div class="text-3xl font-light mb-8">
                {{ number_format($modele->prix_base, 0, ',', ' ') }} <span class="text-lg">FCFA</span>
            </div>

            <div class="space-y-6 text-gray-600 leading-relaxed mb-10 border-t border-b border-orange-50 py-8">
                <h4 class="text-black font-bold uppercase text-xs tracking-widest">Description</h4>
                <p>{{ $modele->description }}</p>

                <ul class="text-xs space-y-2">
                    <li><i class="fa-solid fa-check text-orange-700 mr-2"></i> Matière : 100% Coton Wax & Soie</li>
                    <li><i class="fa-solid fa-check text-orange-700 mr-2"></i> Fabrication : Artisanale au Sénégal</li>
                    <li><i class="fa-solid fa-check text-orange-700 mr-2"></i> Délai : 10 jours ouvrés</li>
                </ul>
            </div>

            <div class="space-y-4">
               <button
                x-data="{}"
                @click="$dispatch('add-to-cart', {
                    id: {{ $modele->id }},
                    nom: '{{ $modele->nom }}',
                    prix: {{ $modele->prix_base }},
                    image: '{{ $modele->images[0] }}'
                })"
                class="w-full bg-[#2D241E] text-white py-5 px-8 font-bold uppercase tracking-[0.2em] text-sm hover:bg-orange-950 transition-all flex justify-between items-center group">
                <span>Ajouter au Panier</span>
                <i class="fa-solid fa-plus group-hover:rotate-90 transition-transform"></i>
            </button>
                <button class="w-full border border-[#2D241E] text-[#2D241E] py-5 px-8 font-bold uppercase tracking-[0.2em] text-sm hover:bg-gray-50 transition-all">
                    Guide des mesures
                </button>
            </div>

            <div class="mt-12 flex items-center gap-6">
                <span class="text-xs font-bold uppercase text-gray-400">Partager</span>
                <div class="flex gap-4">
                    <a href="#" class="hover:text-orange-700"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="hover:text-orange-700"><i class="fa-brands fa-pinterest-p"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
