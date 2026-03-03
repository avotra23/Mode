@extends('layouts.app')

@section('content')
<div class="bg-white min-h-screen">
    <div class="max-w-7xl mx-auto px-6 lg:px-12 py-12">
        {{-- Header --}}
        <div class="border-b border-orange-100 pb-8 mb-12">
            <h1 class="text-4xl font-serif italic text-[#2D241E]">Tableau de Bord</h1>
            <p class="text-[10px] uppercase tracking-[0.3em] text-gray-400 mt-2 font-bold">Aperçu global de la maison Assiat</p>
        </div>

        {{-- Cartes de Statistiques --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Utilisateurs --}}
            <a href="{{ route('admin.users.index') }}" class="group p-8 border border-orange-50 hover:border-orange-200 transition-all duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[10px] uppercase tracking-widest font-bold text-gray-400 mb-1">Communauté</p>
                        <h3 class="text-3xl font-serif text-[#2D241E]">{{ $stats['users'] }} Membres</h3>
                    </div>
                    <i class="fa-solid fa-users text-orange-200 text-2xl group-hover:text-orange-700 transition-colors"></i>
                </div>
                <p class="mt-4 text-[10px] text-orange-700 font-bold uppercase tracking-tighter">Gérer les accès →</p>
            </a>

            {{-- Commandes --}}
            <a href="{{ route('admin.commandes.index') }}" class="group p-8 border border-orange-50 hover:border-orange-200 transition-all duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[10px] uppercase tracking-widest font-bold text-gray-400 mb-1">Ventes Totales</p>
                        <h3 class="text-3xl font-serif text-[#2D241E]">{{ $stats['commandes'] }} Pièces</h3>
                    </div>
                    <i class="fa-solid fa-bag-shopping text-orange-200 text-2xl group-hover:text-orange-700 transition-colors"></i>
                </div>
                <p class="mt-4 text-[10px] text-orange-700 font-bold uppercase tracking-tighter">Voir l'historique →</p>
            </a>

            {{-- Alertes --}}
            <div class="p-8 bg-[#2D241E] text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[10px] uppercase tracking-widest font-bold text-orange-200/50 mb-1">À Traiter</p>
                        <h3 class="text-3xl font-serif text-white">{{ $stats['en_attente'] }} En attente</h3>
                    </div>
                    <i class="fa-solid fa-clock text-orange-400 text-2xl animate-pulse"></i>
                </div>
                <a href="{{ route('admin.commandes.index') }}" class="inline-block mt-4 text-[10px] text-orange-400 font-bold uppercase tracking-widest border-b border-orange-400 pb-1 hover:text-white hover:border-white transition-all">
                    Valider maintenant
                </a>
            </div>
        </div>

        {{-- Section Rapide (Optionnel) --}}
        <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-12">
            <div class="border-l-2 border-orange-700 pl-6">
                <h4 class="font-serif italic text-xl mb-2 text-[#2D241E]">Action Rapide</h4>
                <p class="text-sm text-gray-500 mb-6 italic">Besoin d'ajouter un nouveau talent dans l'équipe ?</p>
                <a href="{{ route('admin.users.index') }}" class="text-[10px] font-bold uppercase tracking-widest bg-gray-50 px-4 py-2 hover:bg-orange-50 transition">
                    + Recruter un Styliste
                </a>
            </div>
        </div>
    </div>
</div>
@endsection