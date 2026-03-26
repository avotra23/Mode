@extends('layouts.app')

@section('content')

{{-- ========== HERO COLLECTIONS ========== --}}
<section class="relative min-h-[60vh] flex items-end bg-[#1A110C] overflow-hidden">
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-br from-[#3D1F0A] via-[#1A110C] to-[#0D0804]"></div>
        <div class="grain-overlay absolute inset-0"></div>
        <div class="coll-orb coll-orb-1"></div>
        <div class="coll-orb coll-orb-2"></div>
    </div>

    {{-- Filigrane --}}
    <span class="absolute right-0 bottom-0 font-serif italic text-[22vw] leading-none text-white/[0.025] select-none pointer-events-none tracking-tighter">Col.</span>

    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-12 pb-20 pt-40 w-full">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-8">
            <div>
                <div class="flex items-center gap-3 mb-6 reveal-up" style="animation-delay:0.1s">
                    <div class="h-px w-10 bg-orange-500"></div>
                    <span class="text-orange-400 text-[10px] font-bold uppercase tracking-[0.5em]">Archives & Saisons</span>
                </div>
                <h1 class="font-serif italic text-white leading-tight reveal-up" style="animation-delay:0.25s">
                    <span class="block text-[clamp(3rem,9vw,7rem)]">Nos</span>
                    <span class="block text-[clamp(3rem,9vw,7rem)] text-orange-300 pl-6 md:pl-16">Collections</span>
                </h1>
            </div>
            <div class="max-w-xs reveal-up" style="animation-delay:0.4s">
                <p class="text-gray-400 text-sm leading-relaxed border-l-2 border-orange-700 pl-5">
                    Chaque collection est un chapitre. Un dialogue entre l'héritage africain et la modernité créative.
                </p>
                <div class="mt-6 flex items-center gap-2 text-gray-500 text-[10px] uppercase tracking-widest">
                    <span class="font-bold text-orange-500">{{ count($collections) }}</span> collections disponibles
                </div>
            </div>
        </div>
    </div>

    {{-- Scroll indicator --}}
    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 reveal-up" style="animation-delay:0.7s">
        <div class="w-px h-10 bg-gradient-to-b from-white/30 to-transparent scroll-line"></div>
    </div>
</section>

{{-- ========== BANDE DÉFILANTE ========== --}}
<div class="bg-orange-700 py-3 overflow-hidden">
    <div class="ticker-track flex gap-0 whitespace-nowrap">
        @for($i = 0; $i < 4; $i++)
        <div class="flex items-center gap-8 px-8 flex-shrink-0">
            <span class="text-white text-[9px] font-black uppercase tracking-[0.5em]">Wax & Tradition</span>
            <span class="text-orange-300">✦</span>
            <span class="text-white text-[9px] font-black uppercase tracking-[0.5em]">Couture Soir</span>
            <span class="text-orange-300">✦</span>
            <span class="text-white text-[9px] font-black uppercase tracking-[0.5em]">Prêt à Porter</span>
            <span class="text-orange-300">✦</span>
            <span class="text-white text-[9px] font-black uppercase tracking-[0.5em]">Sur Mesure</span>
            <span class="text-orange-300">✦</span>
        </div>
        @endfor
    </div>
</div>

{{-- ========== GRILLE COLLECTIONS ========== --}}
<section class="bg-[#FDFBF7] py-28">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">

        {{-- Collections en layout éditorial --}}
        <div class="space-y-6">
            @foreach($collections as $index => $collection)
            @php
                $firstModel = $collection->modeles->first();
                $bgImage = ($firstModel && $firstModel->images) ? asset('storage/' . $firstModel->images[0]) : 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=1200';
                $count = $collection->modeles->count();
                $isEven = $index % 2 === 0;
                $isFeatured = $index === 0;
            @endphp

            @if($isFeatured)
            {{-- PREMIÈRE COLLECTION — Format Hero --}}
            <a href="{{ route('catalogue.index', ['collection' => $collection->id]) }}"
               class="group relative overflow-hidden block aspect-[21/9] md:aspect-[21/8] scroll-reveal bg-[#1A110C]">
                <img src="{{ $bgImage }}" alt="{{ $collection->nom }}"
                     class="w-full h-full object-cover opacity-60 group-hover:opacity-75 group-hover:scale-105 transition-all duration-[2s] ease-out">
                <div class="absolute inset-0 bg-gradient-to-r from-[#1A110C]/90 via-[#1A110C]/40 to-transparent"></div>
                <div class="absolute inset-0 flex items-center p-10 md:p-20">
                    <div>
                        <div class="flex items-center gap-3 mb-4">
                            <span class="bg-orange-700 text-white text-[9px] font-black uppercase tracking-[0.4em] px-4 py-2">Collection Phare</span>
                            <span class="text-white/50 text-[10px] uppercase tracking-widest">{{ $collection->annee ?? '2026' }}</span>
                        </div>
                        <h2 class="font-serif italic text-white text-[clamp(2.5rem,7vw,6rem)] leading-tight mb-6">{{ $collection->nom }}</h2>
                        <p class="text-gray-300 text-sm max-w-md leading-relaxed mb-8 hidden md:block">
                            {{ $collection->description ?? 'Une collection qui célèbre l\'héritage et l\'innovation du textile africain.' }}
                        </p>
                        <div class="flex items-center gap-6">
                            <div class="flex items-center gap-3 text-white text-[10px] font-black uppercase tracking-[0.4em] group/link">
                                <span>Découvrir</span>
                                <div class="w-10 h-px bg-white group-hover/link:w-20 transition-all duration-500"></div>
                            </div>
                            <span class="text-white/30 text-[10px] uppercase">{{ $count }} pièce{{ $count > 1 ? 's' : '' }}</span>
                        </div>
                    </div>
                </div>
                {{-- Coin décoratif --}}
                <div class="absolute bottom-6 right-6 md:bottom-10 md:right-10">
                    <div class="w-12 h-12 md:w-16 md:h-16 border border-white/20 group-hover:border-orange-400/60 transition-colors duration-700 flex items-center justify-center">
                        <svg class="w-5 h-5 text-white/50 group-hover:text-orange-300 group-hover:translate-x-1 group-hover:-translate-y-1 transition-all duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 17L17 7M17 7H7M17 7v10"/>
                        </svg>
                    </div>
                </div>
            </a>

            @else
            {{-- AUTRES COLLECTIONS — Layout alterné --}}
            <div class="scroll-reveal" style="transition-delay: {{ (($index - 1) % 2) * 100 }}ms">
                <a href="{{ route('catalogue.index', ['collection' => $collection->id]) }}"
                   class="group flex flex-col {{ $isEven ? 'md:flex-row' : 'md:flex-row-reverse' }} overflow-hidden bg-white border border-orange-50 hover:border-orange-200 shadow-sm hover:shadow-xl transition-all duration-700">

                    {{-- Image --}}
                    <div class="w-full md:w-1/2 aspect-[4/3] md:aspect-auto md:min-h-[420px] overflow-hidden relative bg-[#2D241E] flex-shrink-0">
                        <img src="{{ $bgImage }}" alt="{{ $collection->nom }}"
                             class="w-full h-full object-cover opacity-80 group-hover:opacity-100 group-hover:scale-105 transition-all duration-[2s] ease-out">
                        {{-- Overlay subtil --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-[#2D241E]/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                        {{-- Numéro --}}
                        <div class="absolute top-4 {{ $isEven ? 'left-4' : 'right-4' }} font-serif italic text-white/20 text-7xl leading-none select-none font-bold">
                            {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                        </div>
                    </div>

                    {{-- Contenu texte --}}
                    <div class="flex-1 flex flex-col justify-between p-8 md:p-14">
                        <div>
                            <div class="flex items-center gap-3 mb-6">
                                <div class="h-px w-8 bg-orange-600"></div>
                                <span class="text-orange-600 text-[9px] font-black uppercase tracking-[0.5em]">{{ $collection->annee ?? '2026' }}</span>
                            </div>
                            <h2 class="font-serif italic text-[#2D241E] text-4xl md:text-5xl leading-tight mb-5 group-hover:text-orange-900 transition-colors duration-500">
                                {{ $collection->nom }}
                            </h2>
                            <p class="text-gray-500 text-sm leading-relaxed mb-8">
                                {{ $collection->description ?? 'Une ligne qui allie tradition et modernité, pour la femme africaine d\'aujourd\'hui.' }}
                            </p>
                        </div>

                        <div>
                            {{-- Stats --}}
                            <div class="flex items-center gap-8 mb-8 pb-8 border-b border-orange-50">
                                <div>
                                    <div class="text-3xl font-serif italic text-[#2D241E] font-bold">{{ $count }}</div>
                                    <div class="text-[9px] text-gray-400 uppercase tracking-widest mt-1">Pièce{{ $count > 1 ? 's' : '' }}</div>
                                </div>
                                <div class="h-8 w-px bg-orange-100"></div>
                                <div>
                                    <div class="text-3xl font-serif italic text-[#2D241E] font-bold">100%</div>
                                    <div class="text-[9px] text-gray-400 uppercase tracking-widest mt-1">Artisanal</div>
                                </div>
                            </div>

                            {{-- CTA --}}
                            <div class="flex items-center gap-4">
                                <div class="inline-flex items-center gap-3 text-[10px] font-black uppercase tracking-[0.4em] text-[#2D241E] group/cta">
                                    Explorer la collection
                                    <svg class="w-5 h-5 group-hover/cta:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endif
            @endforeach
        </div>

        @if($collections->isEmpty())
        <div class="py-40 text-center text-gray-400">
            <div class="text-6xl mb-6 opacity-20">✂️</div>
            <p class="font-serif italic text-2xl">Aucune collection disponible pour le moment.</p>
        </div>
        @endif
    </div>
</section>

{{-- ========== CTA SECTION ========== --}}
<section class="bg-[#2D241E] py-24 relative overflow-hidden">
    <div class="grain-overlay absolute inset-0 opacity-40"></div>
    <div class="relative max-w-7xl mx-auto px-6 lg:px-12">
        <div class="flex flex-col md:flex-row items-center justify-between gap-10">
            <div class="scroll-reveal">
                <span class="text-orange-400 text-[10px] font-bold uppercase tracking-[0.5em] block mb-4">Vous ne trouvez pas ?</span>
                <h3 class="font-serif italic text-white text-4xl md:text-5xl">Une création sur mesure ?</h3>
            </div>
            <div class="flex gap-4 scroll-reveal" style="transition-delay:200ms">
                <a href="{{ route('catalogue.index') }}" class="group inline-flex items-center gap-3 bg-orange-700 hover:bg-orange-600 text-white px-10 py-5 text-[10px] font-black uppercase tracking-[0.4em] transition-all duration-300">
                    Tout le catalogue
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ========== STYLES ========== --}}
<style>
.grain-overlay {
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 512 512' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='1'/%3E%3C/svg%3E");
    opacity: 0.04;
    pointer-events: none;
}
.coll-orb {
    border-radius: 50%;
    filter: blur(80px);
    pointer-events: none;
    animation: floatOrb 12s ease-in-out infinite;
    position: absolute;
}
.coll-orb-1 { width: 500px; height: 500px; background: radial-gradient(circle, rgba(180,60,0,0.3), transparent 70%); top: -150px; left: -100px; }
.coll-orb-2 { width: 350px; height: 350px; background: radial-gradient(circle, rgba(120,40,0,0.2), transparent 70%); bottom: -80px; right: -80px; animation-delay: 4s; }
@keyframes floatOrb {
    0%,100% { transform: translate(0,0); }
    50% { transform: translate(40px,-40px); }
}
.reveal-up {
    opacity: 0;
    transform: translateY(40px);
    animation: revealUp 0.9s cubic-bezier(0.22,1,0.36,1) forwards;
}
@keyframes revealUp { to { opacity:1; transform:translateY(0); } }
.scroll-reveal {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.8s ease, transform 0.8s cubic-bezier(0.22,1,0.36,1);
}
.scroll-reveal.visible { opacity:1; transform:translateY(0); }
.ticker-track { animation: ticker 30s linear infinite; }
@keyframes ticker { from { transform:translateX(0); } to { transform:translateX(-50%); } }
.scroll-line { animation: scrollDown 2s ease-in-out infinite; }
@keyframes scrollDown {
    0%{transform:scaleY(0);transform-origin:top;}
    50%{transform:scaleY(1);transform-origin:top;}
    51%{transform:scaleY(1);transform-origin:bottom;}
    100%{transform:scaleY(0);transform-origin:bottom;}
}
@media (max-width:768px) { .coll-orb { display:none; } }
</style>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const observer = new IntersectionObserver(entries => {
        entries.forEach(e => { if(e.isIntersecting) e.target.classList.add('visible'); });
    }, { threshold: 0.1, rootMargin: '0px 0px -60px 0px' });
    document.querySelectorAll('.scroll-reveal').forEach(el => observer.observe(el));
});
</script>

@endsection