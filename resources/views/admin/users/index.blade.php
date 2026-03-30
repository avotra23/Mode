@extends('layouts.app')

@section('content')
<div class="bg-[#FDFCFB] min-h-screen pb-20 relative overflow-hidden" x-data="{ showForm: false }">
    
    {{-- Éléments de design en arrière-plan --}}
    <div class="absolute top-0 right-0 w-1/3 h-64 bg-gradient-to-l from-orange-50/50 to-transparent pointer-events-none"></div>
    <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-[#2D241E]/5 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-6 lg:px-12 py-12 relative z-10">
        
        {{-- Header & Stats Rapides --}}
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-12 gap-8">
            <div>
                <h1 class="text-6xl font-serif italic text-[#2D241E] leading-tight tracking-tighter">Membres <span class="text-orange-800/20 text-4xl">&</span> Utilisateurs</h1>
                <div class="flex items-center gap-4 mt-4">
                    <span class="h-px w-12 bg-orange-700"></span>
                    <p class="text-[10px] uppercase tracking-[0.5em] text-orange-900/60 font-black">Administration de la Maison</p>
                </div>
            </div>

            {{-- Mini Stats --}}
            <div class="flex gap-6">
                <div class="bg-white p-4 border border-orange-100 shadow-sm min-w-[120px]">
                    <p class="text-[9px] uppercase tracking-widest text-gray-400 mb-1">Total</p>
                    <p class="text-2xl font-serif italic text-[#2D241E]">{{ $users->count() }}</p>
                </div>
                <div class="bg-[#2D241E] p-4 shadow-xl min-w-[120px]">
                    <p class="text-[9px] uppercase tracking-widest text-orange-200/50 mb-1">Actifs</p>
                    <p class="text-2xl font-serif italic text-white">{{ $users->where('role', 'client')->count() }}</p>
                </div>
                <button @click="showForm = !showForm" 
                    class="group relative overflow-hidden bg-orange-700 text-white px-8 py-4 text-[10px] uppercase tracking-[0.2em] font-bold transition-all duration-500 hover:scale-105 active:scale-95 shadow-2xl shadow-orange-900/20">
                    <span class="relative z-10" x-text="showForm ? 'Fermer' : '+ Nouvel Utilisateur'"></span>
                    <div class="absolute inset-0 bg-black translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                </button>
            </div>
        </div>

        {{-- Formulaire d'ajout (Card Design) --}}
        <div x-show="showForm" 
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 -translate-y-12"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="mb-16">
            
            <div class="bg-white rounded-[2rem] p-12 shadow-[0_30px_80px_rgba(45,36,30,0.08)] border border-orange-50 relative overflow-hidden">
                {{-- Décoration de coin --}}
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-orange-50 rounded-full"></div>
                
                <h2 class="font-serif italic text-3xl mb-10 text-[#2D241E]">Inscription Privée</h2>
                
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
                        <div class="space-y-2">
                            <label class="text-[9px] uppercase font-black text-orange-900/40 tracking-widest">Identité</label>
                            <input type="text" name="name" required class="w-full border-0 border-b-2 border-orange-50 bg-transparent px-0 py-3 text-sm focus:ring-0 focus:border-orange-700 transition-all placeholder-gray-200" placeholder="Nom complet">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[9px] uppercase font-black text-orange-900/40 tracking-widest">Contact</label>
                            <input type="email" name="email" required class="w-full border-0 border-b-2 border-orange-50 bg-transparent px-0 py-3 text-sm focus:ring-0 focus:border-orange-700 transition-all placeholder-gray-200" placeholder="Email professionnel">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[9px] uppercase font-black text-orange-900/40 tracking-widest">Rôle au sein de la Maison</label>
                            <select name="role" class="w-full border-0 border-b-2 border-orange-50 bg-transparent px-0 py-3 text-sm focus:ring-0 focus:border-orange-700 cursor-pointer">
                                <option value="client">Client Privé</option>
                                <option value="styliste">Styliste Créateur</option>
                                <option value="admin">Administrateur Senior</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[9px] uppercase font-black text-orange-900/40 tracking-widest">Sécurité (Provisoire)</label>
                            <input type="password" name="password" required class="w-full border-0 border-b-2 border-orange-50 bg-transparent px-0 py-3 text-sm focus:ring-0 focus:border-orange-700 transition-all" placeholder="••••••••">
                        </div>
                    </div>

                    <div class="mt-12 flex justify-end">
                        <button type="submit" class="bg-[#2D241E] text-white px-12 py-5 text-[10px] uppercase font-black tracking-[0.3em] hover:bg-orange-800 transition-all shadow-2xl">
                            Valider l'accès
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Tableau Haute Couture --}}
        <div class="bg-white rounded-[2rem] shadow-[0_20px_60px_rgba(0,0,0,0.02)] overflow-hidden border border-orange-50/50">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[10px] uppercase tracking-[0.3em] text-orange-900/40 bg-orange-50/30">
                            <th class="py-8 px-10">Membre</th>
                            <th class="py-8">Privilèges</th>
                            <th class="py-8 text-center">Activité</th>
                            <th class="py-8">Fidélité</th>
                            <th class="py-8 px-10 text-right">Inscription</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-orange-50">
                        @foreach($users as $user)
                        <tr class="group hover:bg-orange-50/20 transition-all duration-300 cursor-default">
                            <td class="py-7 px-10">
                                <div class="flex items-center gap-5">
                                    <div class="h-12 w-12 rounded-2xl bg-gradient-to-br from-[#2D241E] to-orange-900 flex items-center justify-center text-white font-serif italic text-xl shadow-lg transform group-hover:rotate-6 transition-transform">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-[#2D241E] text-base group-hover:text-orange-800 transition-colors">{{ $user->name }}</div>
                                        <div class="text-[10px] text-gray-400 font-medium tracking-wide uppercase">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @php
                                    $roleBadge = [
                                        'admin' => 'bg-black text-white',
                                        'styliste' => 'bg-orange-100 text-orange-800 border-orange-200',
                                        'client' => 'bg-gray-50 text-gray-500 border-gray-100'
                                    ];
                                @endphp
                                <span class="px-4 py-1.5 border rounded-full text-[8px] font-black uppercase tracking-[0.2em] {{ $roleBadge[$user->role] ?? $roleBadge['client'] }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="inline-block text-center">
                                    <span class="block font-serif italic text-2xl text-[#2D241E] leading-none">{{ $user->commandes_count }}</span>
                                    <span class="text-[8px] uppercase tracking-tighter text-gray-300 font-bold">Achats</span>
                                </div>
                            </td>
                            <td>
                                @if($user->role == 'client' && $user->commandes_count >= 3)
                                    <div class="flex items-center gap-3">
                                        <div class="flex -space-x-1">
                                            @for($i=0; $i<3; $i++)
                                                <div class="w-2 h-2 rounded-full bg-orange-500 shadow-[0_0_10px_rgba(249,115,22,0.5)]"></div>
                                            @endfor
                                        </div>
                                        <span class="text-[9px] font-black uppercase tracking-widest text-orange-800">Cercle Or</span>
                                    </div>
                                @else
                                    <span class="h-1 w-6 bg-gray-100 block rounded-full"></span>
                                @endif
                            </td>
                            <td class="px-10 text-right">
                                <div class="text-[#2D241E] font-serif italic text-sm">{{ $user->created_at->format('d.m.y') }}</div>
                                <div class="text-[9px] text-gray-300 font-bold uppercase tracking-widest">Membre Officiel</div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if($users->isEmpty())
            <div class="text-center py-32 bg-white rounded-[2rem] border-2 border-dashed border-orange-100 mt-8">
                <div class="w-20 h-20 bg-orange-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-orange-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <p class="font-serif italic text-2xl text-gray-300">Les registres sont vides.</p>
                <p class="text-[10px] uppercase tracking-[0.3em] text-gray-400 mt-2">En attente de nouvelles signatures</p>
            </div>
        @endif
    </div>
</div>

<style>
    /* Custom Scrollbar pour un look luxe */
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: #FDFCFB; }
    ::-webkit-scrollbar-thumb { background: #2D241E; border-radius: 10px; }
    
    select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%232D241E'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0 center;
        background-size: 1.2em;
    }

    input:focus::placeholder {
        opacity: 0;
        transform: translateX(10px);
        transition: all 0.3s;
    }
</style>
@endsection