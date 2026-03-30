@extends('layouts.app')

@section('content')
<div class="bg-[#FDFCFB] min-h-screen pb-24 relative overflow-hidden">
    
    {{-- Décorations d'arrière-plan --}}
    <div class="absolute top-0 right-0 w-1/2 h-screen bg-gradient-to-bl from-orange-50/30 to-transparent pointer-events-none"></div>
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-[#2D241E]/5 rounded-full blur-3xl"></div>

    <div class="max-w-7xl mx-auto px-6 lg:px-12 py-12 relative z-10">
        
        {{-- Header Haute Couture --}}
        <div class="flex flex-col md:flex-row justify-between items-end border-b border-[#2D241E]/10 pb-10 mb-16 gap-6">
            <div>
                <span class="text-orange-800 text-[9px] font-black uppercase tracking-[0.6em] block mb-3">Système de Gestion</span>
                <h1 class="text-6xl font-serif italic text-[#2D241E] leading-none tracking-tighter">Maison Assiat</h1>
                <p class="text-xs text-gray-400 mt-4 font-medium uppercase tracking-[0.2em]">Tableau de bord • Session Administrateur</p>
            </div>
            <div class="text-right">
                <div class="text-3xl font-serif italic text-[#2D241E]">{{ date('H:i') }}</div>
                <div class="text-[10px] uppercase tracking-widest text-orange-800 font-bold">{{ date('d M Y') }}</div>
            </div>
        </div>

        {{-- Grille de Statistiques Dynamiques --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            
            {{-- Utilisateurs : Style Minimaliste --}}
            <a href="{{ route('admin.users.index') }}" class="group relative bg-white p-10 shadow-[0_20px_50px_rgba(0,0,0,0.02)] hover:shadow-[0_30px_60px_rgba(45,36,30,0.08)] transition-all duration-500 border border-orange-50/50">
                <div class="flex justify-between items-start mb-10">
                    <div class="w-12 h-12 rounded-full border border-orange-100 flex items-center justify-center group-hover:bg-orange-50 transition-colors">
                        <i class="fa-solid fa-users-line text-orange-800"></i>
                    </div>
                    <span class="text-[40px] font-serif italic text-[#2D241E]/10 group-hover:text-orange-800/20 transition-colors">01</span>
                </div>
                <p class="text-[10px] uppercase tracking-[0.3em] font-black text-gray-400 mb-2">Communauté</p>
                <h3 class="text-4xl font-serif text-[#2D241E] tracking-tight">{{ $stats['users'] }} <span class="text-lg text-gray-300">Membres</span></h3>
                <div class="mt-8 flex items-center gap-2 text-[9px] font-bold uppercase tracking-widest text-orange-800 opacity-0 group-hover:opacity-100 transition-all transform translate-x-[-10px] group-hover:translate-x-0">
                    Gérer les accès <span class="text-lg">→</span>
                </div>
            </a>

            {{-- Commandes : Style "Dark Mode" --}}
            <a href="{{ route('admin.commandes.index') }}" class="group relative bg-[#2D241E] p-10 shadow-2xl transition-all duration-500 hover:-translate-y-2">
                <div class="flex justify-between items-start mb-10">
                    <div class="w-12 h-12 rounded-full bg-orange-800/20 flex items-center justify-center">
                        <i class="fa-solid fa-bag-shopping text-orange-400"></i>
                    </div>
                    <span class="text-[40px] font-serif italic text-white/5">02</span>
                </div>
                <p class="text-[10px] uppercase tracking-[0.3em] font-black text-orange-200/50 mb-2">Ventes Totales</p>
                <h3 class="text-4xl font-serif text-white tracking-tight">{{ $stats['commandes'] }} <span class="text-lg text-white/30">Pièces</span></h3>
                <div class="mt-8 flex items-center gap-2 text-[9px] font-bold uppercase tracking-widest text-orange-400">
                    Consulter le livre d'or <span class="text-lg">→</span>
                </div>
                {{-- Texture de fond --}}
                <div class="absolute bottom-0 right-0 opacity-5 pointer-events-none p-4">
                    <i class="fa-solid fa-crown text-8xl text-white"></i>
                </div>
            </a>

            {{-- Alertes : Style Accentué --}}
            <div class="relative bg-white p-10 border-2 border-[#2D241E] overflow-hidden group">
                <div class="flex justify-between items-start mb-10">
                    <div class="w-12 h-12 bg-orange-800 flex items-center justify-center shadow-lg shadow-orange-800/30">
                        <i class="fa-solid fa-bolt-lightning text-white animate-pulse"></i>
                    </div>
                    <span class="text-[40px] font-serif italic text-[#2D241E]/10">03</span>
                </div>
                <p class="text-[10px] uppercase tracking-[0.3em] font-black text-gray-400 mb-2">Urgences</p>
                <h3 class="text-4xl font-serif text-[#2D241E] tracking-tight">{{ $stats['en_attente'] }} <span class="text-lg text-orange-800 italic">En attente</span></h3>
                
                <a href="{{ route('admin.commandes.index') }}" class="mt-8 block w-full py-4 bg-[#2D241E] text-white text-center text-[9px] uppercase font-bold tracking-[0.3em] hover:bg-orange-800 transition-colors">
                    Traiter les flux
                </a>
            </div>
        </div>

        {{-- Section Actions Rapides & Journal --}}
        <div class="mt-20 grid grid-cols-1 lg:grid-cols-12 gap-16">
            
            <div class="lg:col-span-4 space-y-8">
                <div class="p-8 bg-orange-50/50 rounded-3xl border border-orange-100">
                    <h4 class="font-serif italic text-2xl mb-4 text-[#2D241E]">Membres du Studio</h4>
                    <p class="text-xs text-gray-500 leading-relaxed mb-8 uppercase tracking-widest">Ajouter un nouveau talent à votre équipe créative pour expandre la collection.</p>
                    <a href="{{ route('admin.users.index') }}" class="group inline-flex items-center gap-4 text-[10px] font-black uppercase tracking-[0.2em] text-[#2D241E]">
                        <span class="w-10 h-10 rounded-full bg-[#2D241E] text-white flex items-center justify-center group-hover:scale-110 transition-transform">+</span>
                        Inscrire un collaborateur
                    </a>
                </div>
            </div>

            <div class="lg:col-span-8">
                <div class="flex justify-between items-center mb-8">
                    <h4 class="font-serif italic text-3xl text-[#2D241E]">Flux de la Maison</h4>
                    <span class="h-px flex-1 bg-orange-100 mx-8"></span>
                    <span class="text-[9px] uppercase font-bold text-orange-800 tracking-widest">Temps réel</span>
                </div>
                
                {{-- Placeholder pour une liste d'activités ou graphiques --}}
                <div class="space-y-4">
                    @forelse($recent_activities ?? [] as $activity)
                        {{-- Boucle d'activité si disponible --}}
                    @empty
                        <div class="flex items-center p-6 bg-white border border-orange-50 group hover:border-orange-200 transition-colors">
                            <div class="w-2 h-2 rounded-full bg-orange-700 mr-6"></div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-[#2D241E]">Veille opérationnelle</p>
                                <p class="text-[10px] text-gray-400 uppercase tracking-widest">Le système est parfaitement synchronisé</p>
                            </div>
                            <span class="text-[10px] font-serif italic text-gray-300">À l'instant</span>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    /* Animation douce pour le chargement */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .grid > a, .grid > div {
        animation: fadeInUp 0.6s ease-out forwards;
    }
    .grid > :nth-child(2) { animation-delay: 0.1s; }
    .grid > :nth-child(3) { animation-delay: 0.2s; }
</style>
@endsection