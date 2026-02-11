@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 lg:px-12 py-16">
    <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
        <div>
            <span class="text-orange-700 font-bold uppercase tracking-widest text-xs">Collection 2026</span>
            <h1 class="text-5xl font-serif mt-2 italic">Ma Mode</h1>
        </div>
        <div class="text-right">
            <p class="text-gray-500 max-w-xs text-sm italic border-r-2 border-orange-700 pr-4">
                "Une fusion entre tradition ancestrale et modernité urbaine."
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-16">
        @foreach($modeles as $modele)
        <div class="group relative overflow-hidden" x-data="{ open: false }">
            <div class="relative overflow-hidden aspect-[3/4] bg-gray-100 rounded-sm">
                <img src="{{ $modele->images[0] }}" alt="{{ $modele->nom }}" class="object-cover w-full h-full hover-scale">

                <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-6">
                    <a href="{{ route('catalogue.show', $modele->id) }}"
                       class="w-full bg-white text-black py-4 text-center text-xs uppercase font-bold tracking-widest translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                        Voir les détails
                    </a>
                </div>
            </div>

            <div class="mt-6 flex justify-between items-start">
                <div>
                    <h3 class="text-lg font-serif italic">{{ $modele->nom }}</h3>
                    <p class="text-xs text-orange-800 font-bold uppercase tracking-tighter">{{ $modele->collection->nom }}</p>
                </div>
                <p class="font-medium text-sm">{{ number_format($modele->prix_base, 0, ',', ' ') }} FCFA</p>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
