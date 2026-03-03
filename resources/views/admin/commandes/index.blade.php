@extends('layouts.app')

@section('content')
{{-- Script Alpine.js au cas où --}}
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<div class="bg-white min-h-screen">
    <div class="max-w-7xl mx-auto px-6 lg:px-12 py-12">
        <h1 class="text-4xl font-serif italic text-[#2D241E] mb-12">Gestion des Commandes</h1>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-[10px] uppercase tracking-widest text-gray-400 border-b">
                        <th class="py-4">Client</th>
                        <th>Modèle</th>
                        <th>Montant</th>
                        <th>Statut</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @foreach($commandes as $commande)
                    @php
                        // Vos couleurs exactes
                        $statusColors = [
                            'en_attente'    => 'bg-orange-50 text-orange-700',
                            'en_confection' => 'bg-blue-50 text-blue-700',
                            'termine'       => 'bg-green-50 text-green-700',
                            'livre'         => 'bg-gray-100 text-gray-600',
                            'refuse'        => 'bg-red-50 text-red-700',
                            'annule'        => 'bg-gray-50 text-gray-400',
                        ];
                    @endphp
                    <tr class="border-b border-orange-50 hover:bg-orange-50/20 transition" x-data="{ openValider: false, openRefuser: false }">
                        <td class="py-4">
                            <div class="font-bold">{{ $commande->client->name ?? 'Client inconnu' }}</div>
                            <div class="text-[10px] text-gray-400">{{ $commande->telephone_paiement }}</div>
                        </td>
                        <td>
                            <div class="font-medium">{{ $commande->modele->nom ?? 'Sur mesure' }}</div>
                            <div class="text-[10px] text-gray-400 italic">{{ $commande->taille_choisie }}</div>
                        </td>
                        <td class="font-bold">{{ number_format($commande->prix_total, 0) }} FCFA</td>
                        <td>
                            <span class="px-3 py-1 text-[9px] uppercase font-bold rounded-full {{ $statusColors[$commande->statut] ?? 'bg-gray-50' }}">
                                {{ str_replace('_', ' ', $commande->statut) }}
                            </span>
                        </td>
                        <td class="text-right">
                            @if($commande->statut == 'en_attente')
                                <div class="flex justify-end gap-3">
                                    <button @click="openValider = true" class="text-green-600 font-bold text-[10px] uppercase hover:underline">Valider</button>
                                    <button @click="openRefuser = true" class="text-red-600 font-bold text-[10px] uppercase hover:underline">Refuser</button>
                                </div>

                                <div x-show="openValider" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm">
                                    <div @click.away="openValider = false" class="bg-white p-8 rounded shadow-2xl w-full max-w-sm text-left">
                                        <h3 class="font-serif italic text-2xl mb-2">Valider la commande</h3>
                                        <p class="text-[10px] text-gray-400 uppercase tracking-widest mb-6 font-bold">Le statut passera à "En Confection"</p>
                                        
                                        <form action="{{ route('admin.commandes.valider', $commande->id) }}" method="POST">
                                            @csrf
                                            <div class="mb-6">
                                                <label class="text-[10px] uppercase font-bold text-gray-400 block mb-2">Date de livraison estimée</label>
                                                <input type="date" name="date_prevue" required class="w-full border-gray-200 focus:ring-blue-500 py-3 px-4">
                                            </div>
                                            <button type="submit" class="w-full bg-blue-600 text-white py-3 text-[10px] font-bold uppercase tracking-widest hover:bg-blue-700 transition">Démarrer la confection</button>
                                            <button type="button" @click="openValider = false" class="w-full mt-4 text-[9px] text-gray-400 font-bold uppercase">Retour</button>
                                        </form>
                                    </div>
                                </div>

                                <div x-show="openRefuser" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm">
                                    <div @click.away="openRefuser = false" class="bg-white p-8 rounded shadow-2xl w-full max-w-sm text-left">
                                        <h3 class="font-serif italic text-2xl mb-2 text-red-700">Refuser la commande</h3>
                                        <p class="text-[10px] text-gray-400 uppercase tracking-widest mb-6 font-bold">Le statut passera à "Refusé"</p>
                                        
                                        <form action="{{ route('admin.commandes.refuser', $commande->id) }}" method="POST">
                                            @csrf
                                            <div class="mb-6">
                                                <label class="text-[10px] uppercase font-bold text-gray-400 block mb-2">Raison du refus (Réponse au client)</label>
                                                <textarea name="reponse" required placeholder="Ex: Tissu indisponible..." class="w-full border-gray-200 focus:ring-red-600 py-3 px-4 h-32 text-sm"></textarea>
                                            </div>
                                            <button type="submit" class="w-full bg-red-700 text-white py-3 text-[10px] font-bold uppercase tracking-widest hover:bg-red-800 transition">Confirmer le refus</button>
                                            <button type="button" @click="openRefuser = false" class="w-full mt-4 text-[9px] text-gray-400 font-bold uppercase">Retour</button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <span class="text-[10px] text-gray-400 italic">Aucune action requise</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>
@endsection