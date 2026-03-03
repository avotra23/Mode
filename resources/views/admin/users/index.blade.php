@extends('layouts.app')

@section('content')
<div class="bg-[#FDFCFB] min-h-screen pb-12" x-data="{ showForm: false }">
    <div class="max-w-7xl mx-auto px-6 lg:px-12 py-12">
        
        {{-- Header avec Animation --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end border-b border-orange-100 pb-8 mb-12">
            <div>
                <h1 class="text-5xl font-serif italic text-[#2D241E] leading-tight">Gestion des Utilisateurs</h1>
                <div class="flex items-center gap-4 mt-2">
                    <span class="h-[1px] w-12 bg-orange-200"></span>
                    <p class="text-[10px] uppercase tracking-[0.4em] text-gray-400 font-bold">Membres et Clients de la maison</p>
                </div>
            </div>
            <button @click="showForm = !showForm" 
                class="mt-6 md:mt-0 group flex items-center gap-3 bg-[#2D241E] text-white px-8 py-4 text-[10px] uppercase tracking-[0.2em] font-bold hover:bg-orange-950 transition-all duration-300 shadow-lg shadow-orange-900/10">
                <span x-show="!showForm" class="text-lg leading-none">+</span>
                <span x-show="!showForm">Inscrire un membre</span>
                <span x-show="showForm">Annuler l'inscription</span>
            </button>
        </div>

        {{-- Formulaire d'ajout Amélioré --}}
        <div x-show="showForm" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform -translate-y-4"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             class="mb-16">
            
            <div class="bg-white border border-orange-100 p-10 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 left-0 w-1 h-full bg-[#2D241E]"></div>
                
                <h2 class="font-serif italic text-2xl mb-8 text-[#2D241E]">Nouvelle Fiche Utilisateur</h2>
                
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-x-10 gap-y-8">
                        {{-- Champ Nom --}}
                        <div class="group">
                            <label class="text-[10px] uppercase font-bold text-gray-400 block mb-2 transition-colors group-focus-within:text-[#2D241E]">Nom Complet</label>
                            <input type="text" name="name" required 
                                class="w-full border-0 border-b border-gray-200 px-0 py-2 text-sm focus:ring-0 focus:border-[#2D241E] transition-all placeholder-gray-300"
                                placeholder="ex: Jean Kouassi">
                        </div>

                        {{-- Champ Email --}}
                        <div class="group">
                            <label class="text-[10px] uppercase font-bold text-gray-400 block mb-2 transition-colors group-focus-within:text-[#2D241E]">Adresse Email</label>
                            <input type="email" name="email" required 
                                class="w-full border-0 border-b border-gray-200 px-0 py-2 text-sm focus:ring-0 focus:border-[#2D241E] transition-all placeholder-gray-300"
                                placeholder="client@maison.com">
                        </div>

                        {{-- Champ Rôle --}}
                        <div class="group">
                            <label class="text-[10px] uppercase font-bold text-gray-400 block mb-2">Attribution du Rôle</label>
                            <select name="role" class="w-full border-0 border-b border-gray-200 px-0 py-2 text-sm focus:ring-0 focus:border-[#2D241E] bg-transparent">
                                <option value="client">Client (Par défaut)</option>
                                <option value="styliste">Styliste de la Maison</option>
                                <option value="admin">Administrateur</option>
                            </select>
                        </div>

                        {{-- Champ Password --}}
                        <div class="group md:col-span-2">
                            <label class="text-[10px] uppercase font-bold text-gray-400 block mb-2 transition-colors group-focus-within:text-[#2D241E]">Mot de passe provisoire</label>
                            <input type="password" name="password" required 
                                class="w-full border-0 border-b border-gray-200 px-0 py-2 text-sm focus:ring-0 focus:border-[#2D241E] transition-all">
                        </div>

                        <div class="flex items-end">
                            <button type="submit" class="w-full bg-[#2D241E] text-white py-4 text-[10px] uppercase font-bold tracking-[0.2em] hover:bg-black transition-colors shadow-xl shadow-[#2D241E]/10">
                                Créer le profil
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Tableau Stylisé --}}
        <div class="bg-white border border-orange-50 shadow-sm">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-[10px] uppercase tracking-[0.2em] text-gray-400 border-b border-orange-50">
                        <th class="py-6 px-8">Identité</th>
                        <th>Rôle</th>
                        <th class="text-center">Commandes</th>
                        <th>Statut Fidélité</th>
                        <th class="text-right px-8">Date Inscription</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @foreach($users as $user)
                    <tr class="group border-b border-orange-50 hover:bg-[#FDFCFB] transition-colors">
                        <td class="py-6 px-8">
                            <div class="flex items-center gap-4">
                                <div class="h-10 w-10 bg-orange-50 rounded-full flex items-center justify-center text-[#2D241E] font-serif italic text-lg border border-orange-100 uppercase">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-bold text-[#2D241E] text-sm">{{ $user->name }}</div>
                                    <div class="text-[10px] text-gray-400 tracking-wide">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @php
                                $roleClasses = [
                                    'admin' => 'bg-purple-50 text-purple-700 border-purple-100',
                                    'styliste' => 'bg-blue-50 text-blue-700 border-blue-100',
                                    'client' => 'bg-gray-50 text-gray-600 border-gray-100'
                                ];
                            @endphp
                            <span class="px-3 py-1 border rounded-full text-[9px] font-bold uppercase tracking-wider {{ $roleClasses[$user->role] ?? $roleClasses['client'] }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="text-center font-serif italic text-xl text-[#2D241E]">{{ $user->commandes_count }}</td>
                        <td>
                            @if($user->role == 'client' && $user->commandes_count >= 3)
                                <div class="inline-flex items-center gap-2 text-orange-800 bg-orange-50 px-3 py-1 rounded-full border border-orange-100">
                                    <span class="relative flex h-2 w-2">
                                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                                      <span class="relative inline-flex rounded-full h-2 w-2 bg-orange-500"></span>
                                    </span>
                                    <span class="text-[9px] font-bold uppercase tracking-widest text-orange-700">Client Fidèle</span>
                                </div>
                            @else
                                <span class="text-gray-200">——</span>
                            @endif
                        </td>
                        <td class="text-right px-8">
                            <span class="text-gray-400 text-[11px] font-medium tracking-tighter">{{ $user->created_at->format('d M Y') }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($users->isEmpty())
            <div class="text-center py-20 bg-white border border-dashed border-orange-200 mt-4">
                <p class="font-serif italic text-gray-400">Aucun utilisateur enregistré pour le moment.</p>
            </div>
        @endif
    </div>
</div>

<style>
    /* Optionnel : cacher les flèches du select par défaut pour un look plus minimal */
    select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23D1D5DB'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0 center;
        background-size: 1em;
    }
</style>
@endsection