@extends('layouts.app')

@section('content')
<div class="bg-white min-h-screen pb-20">
    <div class="max-w-7xl mx-auto px-6 lg:px-12 py-12">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 border-b border-orange-100 pb-8">
            <div>
                <h1 class="text-4xl font-serif italic text-[#2D241E]">Historique de Commandes</h1>
                <p class="text-[10px] uppercase tracking-[0.3em] text-gray-400 mt-2 font-bold">Suivez vos pièces artisanales en cours de création</p>
            </div>

            <form action="{{ route('commandes.index') }}" method="GET" class="relative group">
                <input type="text" name="search" value="{{ $search }}" 
                       placeholder="Rechercher une commande..." 
                       class="pl-4 pr-10 py-2 border-0 border-b border-orange-200 focus:ring-0 focus:border-orange-700 text-sm font-serif italic w-64 transition-all">
                <button type="submit" class="absolute right-2 top-2 text-gray-400 group-hover:text-orange-700">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </button>
            </form>
        </div>

        <div class="mt-12 space-y-8">
            @forelse($commandes as $commande)
                <div class="group bg-white border border-orange-50 hover:border-orange-200 transition-all duration-300 p-6 md:p-8 shadow-sm hover:shadow-md">
                    <div class="flex flex-col md:flex-row gap-8">
                        <div class="w-full md:w-32 h-40 bg-gray-50 flex-shrink-0 overflow-hidden">
                            @if($commande->modele && $commande->modele->images && count($commande->modele->images) > 0)
                                {{-- On récupère la première image du tableau JSON --}}
                                <img src="{{ asset('storage/' . $commande->modele->images[0]) }}" 
                                    class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-orange-200">
                                    <i class="fa-solid fa-shirt text-3xl"></i>
                                </div>
                            @endif
                        </div>

                        <div class="flex-1 flex flex-col justify-between">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-xl font-serif text-[#2D241E]">{{ $commande->modele->nom ?? 'Modèle personnalisé' }}</h3>
                                    <div class="flex flex-wrap gap-4 mt-2 text-[10px] uppercase tracking-widest font-bold text-gray-400">
                                        <span>Taille: <span class="text-black">{{ $commande->taille_choisie }}</span></span>
                                        <span>Tissu: <span class="text-black">{{ $commande->tissu_choisi }}</span></span>
                                        <span>ID: #ORD-{{ $commande->id }}</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold text-[#2D241E]">{{ number_format($commande->prix_total, 0, ',', ' ') }} FCFA</p>
                                    
                                    {{-- Gestion dynamique des couleurs du badge selon le statut --}}
                                    @php
                                        $statusColors = [
                                            'en_attente'     => 'bg-orange-50 text-orange-700',
                                            'en_confection'  => 'bg-blue-50 text-blue-700',
                                            'termine'        => 'bg-green-50 text-green-700',
                                            'livre'          => 'bg-gray-100 text-gray-600',
                                            'refuse'         => 'bg-red-50 text-red-700',
                                            'annule'         => 'bg-gray-50 text-gray-400',
                                        ];
                                        $currentStyle = $statusColors[$commande->statut] ?? 'bg-gray-100 text-gray-800';
                                    @endphp

                                    <span class="inline-block px-3 py-1 mt-2 text-[9px] uppercase tracking-[0.2em] font-bold rounded-full {{ $currentStyle }}">
                                        {{ str_replace('_', ' ', $commande->statut) }}
                                    </span>
                                </div>
                            </div>

                            <div class="mt-6 flex flex-col md:flex-row md:items-center justify-between gap-4 border-t border-orange-50 pt-4">
                                <div class="text-[11px] italic text-gray-500 font-serif">
                                    @if($commande->date_prevue)
                                        Livraison estimée : {{ \Carbon\Carbon::parse($commande->date_prevue)->translatedFormat('d F Y') }}
                                    @endif
                                </div>

                                <div class="flex items-center space-x-6">
                                    @if($commande->statut === 'en_attente')
                                        <form action="{{ route('commandes.destroy', $commande) }}" method="POST" 
                                              onsubmit="return confirm('Souhaitez-vous vraiment annuler cette commande ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-[10px] uppercase tracking-widest font-bold text-red-800 hover:text-red-500 transition">
                                                Annuler la commande
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-[10px] uppercase tracking-widest font-bold text-gray-300 cursor-not-allowed">
                                            Annulation indisponible
                                        </span>
                                    @endif
                                    
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-20 border border-dashed border-orange-200">
                    <i class="fa-solid fa-box-open text-4xl text-orange-100 mb-4"></i>
                    <p class="font-serif italic text-gray-400 text-lg">Vous n'avez pas encore passé de commande.</p>
                    <a href="{{ route('catalogue.index') }}" class="inline-block mt-4 text-[10px] uppercase tracking-widest font-bold text-orange-700 border-b border-orange-700 pb-1">
                        Découvrir la collection
                    </a>
                </div>
            @endforelse
        </div>

        <div class="mt-12">
            {{ $commandes->appends(['search' => $search])->links() }}
        </div>
    </div>
</div>
@endsection