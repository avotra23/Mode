@extends('layouts.app')

@section('content')
{{-- Script Alpine.js --}}
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<div class="bg-[#FDFCFB] min-h-screen pb-20">
    <div class="max-w-7xl mx-auto px-6 lg:px-12 py-12">
        
        {{-- Header avec Breadcrumb --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end border-b border-orange-100 pb-10 mb-12">
            <div>
                <nav class="flex items-center gap-2 text-[9px] uppercase tracking-[0.3em] text-gray-400 mb-4">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-orange-800">Atelier</a>
                    <span>/</span>
                    <span class="text-orange-900 font-bold">Commandes</span>
                </nav>
                <h1 class="text-5xl font-serif italic text-[#2D241E]">Suivi des Confections</h1>
            </div>
            <div class="mt-6 md:mt-0 bg-white px-6 py-3 border border-orange-100 shadow-sm">
                <span class="text-[10px] uppercase tracking-widest text-gray-400 block">Total en attente</span>
                <span class="text-2xl font-serif italic text-orange-800">{{ $commandes->where('statut', 'en_attente')->count() }} dossiers</span>
            </div>
        </div>

        {{-- Table Container --}}
        <div class="bg-white rounded-[2rem] shadow-[0_20px_60px_rgba(45,36,30,0.03)] border border-orange-50/50 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[10px] uppercase tracking-[0.2em] text-orange-900/40 bg-orange-50/20">
                            <th class="py-8 px-10">Détails Client</th>
                            <th class="py-8">Pièce Commandée</th>
                            <th class="py-8">Transaction</th>
                            <th class="py-8">État du Dossier</th>
                            <th class="py-8 px-10 text-right">Décision</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-orange-50">
                        @foreach($commandes as $commande)
                        @php
                            $statusConfig = [
                                'en_attente'     => ['class' => 'bg-orange-50 text-orange-700 border-orange-100', 'label' => 'Nouvelle Demande'],
                                'en_confection'  => ['class' => 'bg-blue-50 text-blue-700 border-blue-100', 'label' => 'À l\'Atelier'],
                                'termine'        => ['class' => 'bg-emerald-50 text-emerald-700 border-emerald-100', 'label' => 'Prêt'],
                                'livre'          => ['class' => 'bg-gray-50 text-gray-400 border-gray-100', 'label' => 'Archivé / Livré'],
                                'refuse'         => ['class' => 'bg-red-50 text-red-700 border-red-100', 'label' => 'Refusé'],
                            ];
                            $currentStatus = $statusConfig[$commande->statut] ?? ['class' => 'bg-gray-50 text-gray-500', 'label' => $commande->statut];
                        @endphp
                        
                        <tr class="group hover:bg-[#FDFCFB] transition-all duration-300" x-data="{ openValider: false, openRefuser: false }">
                            {{-- Client --}}
                            <td class="py-8 px-10">
                                <div class="flex flex-col">
                                    <span class="font-bold text-[#2D241E] text-base mb-1">{{ $commande->client->name ?? 'Client Anonyme' }}</span>
                                    <span class="text-[11px] text-gray-400 font-medium tracking-tighter flex items-center gap-2">
                                        <i class="fa-solid fa-phone text-[8px]"></i> {{ $commande->telephone_paiement }}
                                    </span>
                                </div>
                            </td>

                            {{-- Modèle --}}
                            <td>
                                <div class="flex flex-col">
                                    <span class="text-[#2D241E] font-serif italic text-lg">{{ $commande->modele->nom ?? 'Création Sur Mesure' }}</span>
                                    <span class="text-[10px] uppercase tracking-widest text-orange-800/60 font-bold mt-1">Taille : {{ $commande->taille_choisie }}</span>
                                </div>
                            </td>

                            {{-- Montant --}}
                            <td>
                                <div class="inline-block px-4 py-2 bg-gray-50 rounded-lg border border-gray-100">
                                    <span class="font-bold text-[#2D241E]">{{ number_format($commande->prix_total, 0, ',', ' ') }}</span>
                                    <span class="text-[9px] font-black text-gray-300 ml-1 uppercase">CFA</span>
                                </div>
                            </td>

                            {{-- Statut --}}
                            <td>
                                <span class="px-4 py-1.5 border rounded-full text-[9px] font-black uppercase tracking-widest {{ $currentStatus['class'] }}">
                                    {{ $currentStatus['label'] }}
                                </span>
                            </td>

                            {{-- Actions --}}
                            <td class="px-10 text-right">
                                @if($commande->statut == 'en_attente')
                                    <div class="flex justify-end items-center gap-6">
                                        <button @click="openValider = true" class="group/btn flex items-center gap-2 text-emerald-600 text-[10px] font-black uppercase tracking-widest transition-all hover:gap-4">
                                            Accepter <span class="text-lg leading-none">→</span>
                                        </button>
                                        <button @click="openRefuser = true" class="text-red-300 hover:text-red-700 text-[10px] font-black uppercase tracking-widest transition-colors">
                                            Décliner
                                        </button>
                                    </div>

                                    {{-- Modal Valider --}}
                                    <div x-show="openValider" x-cloak x-transition.opacity class="fixed inset-0 z-[100] flex items-center justify-center bg-[#2D241E]/90 backdrop-blur-md p-4">
                                        <div @click.away="openValider = false" class="bg-white rounded-[2.5rem] p-10 w-full max-w-lg shadow-2xl relative overflow-hidden">
                                            <div class="absolute top-0 left-0 w-full h-2 bg-emerald-500"></div>
                                            <h3 class="font-serif italic text-4xl mb-4 text-[#2D241E]">Lancer la confection</h3>
                                            <p class="text-sm text-gray-500 mb-8 leading-relaxed">Veuillez définir une date de fin de travaux. Le client recevra une notification pour commencer ses essayages.</p>
                                            
                                            <form action="{{ route('admin.commandes.valider', $commande->id) }}" method="POST" class="space-y-8">
                                                @csrf
                                                <div class="group">
                                                    <label class="text-[10px] uppercase font-black text-gray-400 tracking-widest block mb-3 group-focus-within:text-emerald-600 transition-colors">Date de livraison estimée</label>
                                                    <input type="date" name="date_prevue" required class="w-full border-0 border-b-2 border-gray-100 py-4 focus:ring-0 focus:border-emerald-600 text-xl font-serif italic transition-all">
                                                </div>
                                                <div class="flex flex-col gap-4">
                                                    <button type="submit" class="w-full bg-[#2D241E] text-white py-5 rounded-full text-[10px] font-black uppercase tracking-[0.3em] hover:bg-emerald-700 transition-all shadow-xl">Confirmer l'entrée en atelier</button>
                                                    <button type="button" @click="openValider = false" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest hover:text-red-600 transition-colors">Annuler</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    {{-- Modal Refuser --}}
                                    <div x-show="openRefuser" x-cloak x-transition.opacity class="fixed inset-0 z-[100] flex items-center justify-center bg-[#2D241E]/90 backdrop-blur-md p-4">
                                        <div @click.away="openRefuser = false" class="bg-white rounded-[2.5rem] p-10 w-full max-w-lg shadow-2xl">
                                            <h3 class="font-serif italic text-4xl mb-4 text-red-800">Décliner le dossier</h3>
                                            <p class="text-sm text-gray-500 mb-8 leading-relaxed">Expliquez poliment au client pourquoi cette pièce ne peut être confectionnée actuellement (rupture de tissu, délai trop court, etc.)</p>
                                            
                                            <form action="{{ route('admin.commandes.refuser', $commande->id) }}" method="POST" class="space-y-8">
                                                @csrf
                                                <div class="group">
                                                    <label class="text-[10px] uppercase font-black text-gray-400 tracking-widest block mb-3">Note explicative</label>
                                                    <textarea name="reponse" required placeholder="Décrivez la raison..." class="w-full border-2 border-gray-50 rounded-3xl p-6 h-40 focus:ring-0 focus:border-red-100 bg-gray-50/50 text-sm italic transition-all"></textarea>
                                                </div>
                                                <div class="flex flex-col gap-4">
                                                    <button type="submit" class="w-full bg-red-800 text-white py-5 rounded-full text-[10px] font-black uppercase tracking-[0.3em] hover:bg-red-900 transition-all">Envoyer le refus</button>
                                                    <button type="button" @click="openRefuser = false" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest hover:text-black transition-colors">Retour au registre</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    <div class="flex items-center justify-end gap-2 text-gray-300">
                                        <i class="fa-solid fa-circle-check text-[10px]"></i>
                                        <span class="text-[9px] uppercase font-bold tracking-widest italic">Traité</span>
                                    </div>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- État Vide --}}
        @if($commandes->isEmpty())
            <div class="mt-20 text-center py-40 bg-white rounded-[3rem] border-2 border-dashed border-orange-100">
                <div class="w-24 h-24 bg-orange-50 rounded-full flex items-center justify-center mx-auto mb-8">
                    <i class="fa-solid fa-scroll text-3xl text-orange-200"></i>
                </div>
                <h2 class="text-3xl font-serif italic text-gray-300 italic">Aucun carnet de commande actif.</h2>
                <p class="text-[10px] uppercase tracking-[0.4em] text-gray-400 mt-4">La maison est en attente de nouvelles inspirations</p>
            </div>
        @endif
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
    
    /* Style personnalisé pour les inputs date */
    input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(13%) sepia(10%) saturate(1000%) hue-rotate(320deg) brightness(95%) contrast(90%);
        cursor: pointer;
    }
</style>
@endsection