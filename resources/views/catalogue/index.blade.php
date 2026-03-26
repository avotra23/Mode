@extends('layouts.app')

@section('content')

{{-- ========== HERO SECTION ========== --}}
<section class="relative min-h-screen flex flex-col justify-end overflow-hidden bg-[#1A110C]">

    {{-- Fond animé avec particules --}}
    <div class="absolute inset-0 z-0">
        <div class="hero-bg-gradient absolute inset-0"></div>
        <div class="grain-overlay absolute inset-0"></div>
        {{-- Orbes flottants --}}
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
    </div>

    {{-- Texte filigrane géant --}}
    <span class="absolute right-0 top-1/2 -translate-y-1/2 font-serif italic text-[22vw] leading-none text-white/[0.03] select-none pointer-events-none z-0 tracking-tighter">Mode</span>

    {{-- Contenu principal du Hero --}}
    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-12 pb-24 pt-48">

        {{-- Badge flottant --}}
        <div class="inline-flex items-center gap-3 border border-orange-500/30 bg-orange-500/10 backdrop-blur-sm px-5 py-2 rounded-full mb-10 reveal-up" style="animation-delay:0.1s">
            <span class="w-2 h-2 rounded-full bg-orange-400 animate-pulse"></span>
            <span class="text-orange-300 text-[10px] font-bold uppercase tracking-[0.4em]">Nouvelle Collection 2026</span>
        </div>

        <h1 class="font-serif italic text-white leading-[0.85] mb-8">
            <span class="block text-[clamp(3.5rem,12vw,10rem)] reveal-up" style="animation-delay:0.2s">L'Élégance</span>
            <span class="block text-[clamp(3.5rem,12vw,10rem)] reveal-up pl-4 md:pl-20 text-orange-300" style="animation-delay:0.35s">Africaine</span>
            <span class="block text-[clamp(3.5rem,12vw,10rem)] reveal-up" style="animation-delay:0.5s">Réinventée.</span>
        </h1>

        <div class="flex flex-col sm:flex-row items-start sm:items-end justify-between gap-8 mt-12 reveal-up" style="animation-delay:0.65s">
            <p class="text-gray-400 text-sm max-w-sm leading-relaxed border-l-2 border-orange-700 pl-5">
                Des tissus d'exception façonnés par des mains d'artisans. Chaque pièce raconte une histoire, chaque couture est une signature.
            </p>
            <div class="flex gap-4">
                <a href="#catalogue" class="group flex items-center gap-3 bg-orange-700 hover:bg-orange-600 text-white px-8 py-4 text-[10px] uppercase tracking-[0.3em] font-bold transition-all duration-300">
                    Découvrir
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
                <a href="{{ route('collections.index') }}" class="flex items-center gap-3 border border-white/20 text-white/70 hover:text-white hover:border-white/50 px-8 py-4 text-[10px] uppercase tracking-[0.3em] font-bold transition-all duration-300">
                    Collections
                </a>
            </div>
        </div>
    </div>

    {{-- Indicateur de scroll --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-10 flex flex-col items-center gap-2 reveal-up" style="animation-delay:1s">
        <span class="text-white/30 text-[9px] uppercase tracking-[0.5em]">Défiler</span>
        <div class="w-px h-12 bg-gradient-to-b from-white/30 to-transparent scroll-line"></div>
    </div>
</section>

{{-- ========== BANDE DÉFILANTE ========== --}}
<div class="bg-orange-700 py-4 overflow-hidden border-y border-orange-600">
    <div class="ticker-track flex gap-0 whitespace-nowrap">
        @for($i = 0; $i < 4; $i++)
        <div class="flex items-center gap-10 px-10 flex-shrink-0">
            <span class="text-white text-[10px] font-black uppercase tracking-[0.5em]">Nouvelle Collection</span>
            <span class="text-orange-300 text-xl font-serif italic">✦</span>
            <span class="text-white text-[10px] font-black uppercase tracking-[0.5em]">Artisanat Africain</span>
            <span class="text-orange-300 text-xl font-serif italic">✦</span>
            <span class="text-white text-[10px] font-black uppercase tracking-[0.5em]">Pièces Exclusives</span>
            <span class="text-orange-300 text-xl font-serif italic">✦</span>
            <span class="text-white text-[10px] font-black uppercase tracking-[0.5em]">Sur Mesure</span>
            <span class="text-orange-300 text-xl font-serif italic">✦</span>
        </div>
        @endfor
    </div>
</div>

{{-- ========== CHIFFRES CLÉS ========== --}}
<section class="bg-[#FDFBF7] py-20 border-b border-orange-100">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            @foreach([
                ['num' => '500+', 'label' => 'Créations uniques'],
                ['num' => '12', 'label' => 'Collections actives'],
                ['num' => '100%', 'label' => 'Artisanat local'],
                ['num' => '3K+', 'label' => 'Clientes fidèles'],
            ] as $i => $stat)
            <div class="text-center scroll-reveal" style="transition-delay: {{ $i * 100 }}ms">
                <div class="text-5xl md:text-6xl font-serif italic text-orange-800 mb-2">{{ $stat['num'] }}</div>
                <div class="text-[10px] uppercase tracking-[0.3em] text-gray-400 font-bold">{{ $stat['label'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ========== CATALOGUE PRINCIPAL ========== --}}
<section id="catalogue" class="bg-[#FDFBF7] py-28">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">

        {{-- En-tête section --}}
        <div class="flex flex-col md:flex-row justify-between items-end mb-20 gap-8">
            <div>
                <span class="text-orange-700 font-bold uppercase tracking-[0.5em] text-[10px] block mb-4 scroll-reveal">Nos Créations</span>
                <h2 class="text-5xl md:text-7xl font-serif italic text-[#2D241E] leading-tight scroll-reveal" style="transition-delay:100ms">
                    Pièces<br><span class="text-orange-200 stroke-text">Signature</span>
                </h2>
            </div>
            <div class="text-right scroll-reveal" style="transition-delay:200ms">
                <div class="h-px w-16 bg-orange-700 ml-auto mb-4"></div>
                <p class="text-gray-400 text-xs leading-relaxed max-w-[200px]">L'art du vêtement africain contemporain, pièce par pièce.</p>
            </div>
        </div>

        {{-- Grille artistique asymétrique --}}
        <div class="catalogue-grid">
            @foreach($modeles as $index => $modele)
                @php
                    $imagePath = ($modele->images && count($modele->images) > 0) ? $modele->images[0] : null;
                    $layouts = [
                        ['grid' => 'col-span-12 md:col-span-7', 'aspect' => 'aspect-[4/3]', 'offset' => ''],
                        ['grid' => 'col-span-12 md:col-span-5', 'aspect' => 'aspect-[3/4]', 'offset' => 'md:mt-24'],
                        ['grid' => 'col-span-12 md:col-span-4', 'aspect' => 'aspect-[3/4]', 'offset' => 'md:-mt-12'],
                        ['grid' => 'col-span-12 md:col-span-8', 'aspect' => 'aspect-[16/9]', 'offset' => ''],
                        ['grid' => 'col-span-12 md:col-span-6', 'aspect' => 'aspect-[4/3]', 'offset' => 'md:mt-16'],
                        ['grid' => 'col-span-12 md:col-span-6', 'aspect' => 'aspect-[3/4]', 'offset' => ''],
                    ];
                    $layout = $layouts[$index % count($layouts)];
                @endphp

                <div class="{{ $layout['grid'] }} {{ $layout['offset'] }} group relative scroll-reveal" style="transition-delay: {{ ($index % 3) * 150 }}ms">
                    
                    {{-- Numéro de pièce flottant --}}
                    <div class="absolute -top-5 -left-3 z-20 font-serif italic text-[4rem] leading-none text-orange-100/80 select-none pointer-events-none font-bold">
                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                    </div>

                    {{-- Container image --}}
                    <div class="relative overflow-hidden {{ $layout['aspect'] }} bg-[#2D241E] shadow-xl group-hover:shadow-2xl transition-shadow duration-700">

                        {{-- Image --}}
                        <img src="{{ $imagePath ? asset('storage/' . $imagePath) : 'https://images.unsplash.com/photo-1539109136881-3be0616acf4b?q=80&w=800' }}"
                             alt="{{ $modele->nom }}"
                             loading="lazy"
                             class="object-cover w-full h-full transition-transform duration-[2.5s] ease-out group-hover:scale-110 opacity-85 group-hover:opacity-100">

                        {{-- Overlay gradient --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-[#1A110C]/90 via-[#1A110C]/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                        {{-- Contenu overlay --}}
                        <div class="absolute inset-0 flex flex-col justify-between p-6 opacity-0 group-hover:opacity-100 transition-all duration-500 translate-y-4 group-hover:translate-y-0">
                            {{-- Prix badge top --}}
                            <div class="flex justify-end">
                                <span class="bg-orange-700 text-white text-[10px] font-bold uppercase tracking-widest px-4 py-2">
                                    {{ number_format($modele->prix_base, 0, ',', ' ') }} FCFA
                                </span>
                            </div>
                            {{-- CTA bas --}}
                            <a href="{{ route('catalogue.show', $modele->id) }}"
                               class="self-start flex items-center gap-3 text-white text-[10px] font-black uppercase tracking-[0.4em] group/link hover:gap-5 transition-all duration-300 border-b border-white/30 pb-2">
                                Voir la pièce
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                        </div>

                        {{-- Coin décoratif --}}
                        <div class="absolute top-0 left-0 w-8 h-8 border-l-2 border-t-2 border-orange-400/0 group-hover:border-orange-400/80 transition-all duration-700 delay-100"></div>
                        <div class="absolute bottom-0 right-0 w-8 h-8 border-r-2 border-b-2 border-orange-400/0 group-hover:border-orange-400/80 transition-all duration-700 delay-100"></div>
                    </div>

                    {{-- Infos sous image --}}
                    <div class="mt-6 px-1">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="text-[9px] text-orange-700 font-black uppercase tracking-[0.5em] block mb-2">
                                    {{ $modele->collection->nom ?? 'Ligne Exclusive' }}
                                </span>
                                <h3 class="text-2xl md:text-3xl font-serif italic text-[#2D241E] leading-tight group-hover:text-orange-900 transition-colors duration-300">
                                    {{ $modele->nom }}
                                </h3>
                            </div>
                            <a href="{{ route('catalogue.show', $modele->id) }}" class="mt-1 flex-shrink-0 w-10 h-10 flex items-center justify-center border border-orange-200 hover:bg-orange-700 hover:border-orange-700 hover:text-white text-orange-700 transition-all duration-300 rounded-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                        </div>

                        {{-- Ligne décorative animée --}}
                        <div class="mt-5 h-px bg-orange-100 relative overflow-hidden">
                            <div class="absolute inset-y-0 left-0 bg-orange-600 w-1/4 group-hover:w-full transition-all duration-[1.5s] ease-in-out"></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- CTA voir tout --}}
        <div class="text-center mt-24 scroll-reveal">
            <a href="{{ route('catalogue.index') }}" class="group inline-flex items-center gap-4 border-2 border-[#2D241E] text-[#2D241E] hover:bg-[#2D241E] hover:text-white px-12 py-5 text-[10px] font-black uppercase tracking-[0.5em] transition-all duration-500">
                Voir toutes nos pièces
                <svg class="w-4 h-4 group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- ========== SECTION SAVOIR-FAIRE ========== --}}
<section class="bg-[#2D241E] py-28 overflow-hidden relative">
    <div class="absolute inset-0 grain-overlay opacity-50"></div>
    <span class="absolute -right-20 top-1/2 -translate-y-1/2 font-serif italic text-[20vw] text-white/[0.02] leading-none select-none">Atelier</span>

    <div class="relative max-w-7xl mx-auto px-6 lg:px-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
            <div>
                <span class="text-orange-400 font-bold uppercase tracking-[0.5em] text-[10px] block mb-6 scroll-reveal">Notre Philosophie</span>
                <h2 class="text-5xl md:text-6xl font-serif italic text-white leading-tight mb-8 scroll-reveal" style="transition-delay:100ms">
                    L'Art de la<br>Couture Africaine
                </h2>
                <p class="text-gray-400 leading-relaxed mb-10 text-sm scroll-reveal" style="transition-delay:200ms">
                    Chaque vêtement est une conversation entre le tissu et l'artisan. Nous sélectionnons des étoffes rares, des wax aux soies brodées, pour donner vie à des pièces qui traversent le temps.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 scroll-reveal" style="transition-delay:300ms">
                    @foreach([
                        ['icon' => '✂️', 'title' => 'Tailleur d\'art', 'desc' => 'Coupes architecturales précises'],
                        ['icon' => '🪡', 'title' => 'Tissus rares', 'desc' => 'Sélection de matières d\'exception'],
                        ['icon' => '👁️', 'title' => 'Détail unique', 'desc' => 'Finitions faites à la main'],
                    ] as $feat)
                    <div class="border border-white/10 p-6 hover:border-orange-500/40 transition-colors duration-500 group">
                        <div class="text-2xl mb-3">{{ $feat['icon'] }}</div>
                        <div class="text-white font-bold text-xs uppercase tracking-widest mb-1">{{ $feat['title'] }}</div>
                        <div class="text-gray-500 text-[10px] leading-relaxed">{{ $feat['desc'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Collage d'images --}}
            <div class="relative h-[500px] hidden lg:block scroll-reveal" style="transition-delay:200ms">
                <div class="absolute top-0 left-0 w-[55%] aspect-[3/4] overflow-hidden shadow-2xl border border-white/10">
                    <img src="https://images.unsplash.com/photo-1558171813-0d5e4c1c3028?q=80&w=600" alt="Atelier" class="w-full h-full object-cover hover:scale-105 transition-transform duration-1000">
                </div>
                <div class="absolute bottom-0 right-0 w-[50%] aspect-[4/5] overflow-hidden shadow-2xl border border-orange-500/20">
                    <img src="https://images.unsplash.com/photo-1509631179647-0177331693ae?q=80&w=600" alt="Tissu" class="w-full h-full object-cover hover:scale-105 transition-transform duration-1000">
                </div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-28 h-28 bg-orange-700 flex items-center justify-center shadow-xl z-10">
                    <span class="text-white font-serif italic text-lg text-center leading-tight">Depuis<br>2020</span>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- ========== SECTION TÉMOIGNAGES ========== --}}
<section class="bg-orange-50 py-24 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">
        <div class="text-center mb-16">
            <span class="text-orange-700 font-bold uppercase tracking-[0.5em] text-[10px] block mb-4 scroll-reveal">Elles nous font confiance</span>
            <h2 class="text-4xl md:text-5xl font-serif italic text-[#2D241E] scroll-reveal" style="transition-delay:100ms">Ce qu'elles disent</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach([
                ['name' => 'Aminata D.', 'role' => 'Cliente Premium', 'text' => 'La robe que j\'ai commandée était d\'une qualité exceptionnelle. Le tissu wax choisi par la styliste était parfait pour mon mariage.', 'stars' => 5],
                ['name' => 'Fatoumata K.', 'role' => 'Cliente Fidèle', 'text' => 'Chaque pièce est une œuvre d\'art. Je recommande Assiat Mode à toutes mes amies. Service impeccable et livraison rapide.', 'stars' => 5],
                ['name' => 'Mariam S.', 'role' => 'Nouvelle Cliente', 'text' => 'J\'ai découvert cette boutique par hasard et je suis conquise. Le design est unique, on ne trouve pas ça ailleurs.', 'stars' => 5],
            ] as $i => $testi)
            <div class="bg-white p-8 shadow-sm border border-orange-100 hover:shadow-lg hover:border-orange-200 transition-all duration-500 scroll-reveal" style="transition-delay: {{ $i * 150 }}ms">
                <div class="flex gap-1 mb-6">
                    @for($s = 0; $s < $testi['stars']; $s++)
                        <span class="text-orange-400 text-sm">★</span>
                    @endfor
                </div>
                <p class="text-gray-600 text-sm leading-relaxed font-serif italic mb-8">"{{ $testi['text'] }}"</p>
                <div class="flex items-center gap-3 border-t border-orange-50 pt-6">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-orange-300 to-orange-700 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                        {{ substr($testi['name'], 0, 1) }}
                    </div>
                    <div>
                        <div class="font-bold text-[#2D241E] text-sm">{{ $testi['name'] }}</div>
                        <div class="text-[10px] text-orange-600 uppercase tracking-widest">{{ $testi['role'] }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ========== SECTION CTA FINAL ========== --}}
<section class="relative bg-[#1A110C] py-32 overflow-hidden">
    <div class="absolute inset-0 grain-overlay opacity-60"></div>
    <div class="orb orb-cta-1 absolute"></div>
    <div class="orb orb-cta-2 absolute"></div>

    <div class="relative max-w-3xl mx-auto px-6 text-center scroll-reveal">
        <span class="text-orange-400 font-bold uppercase tracking-[0.5em] text-[10px] block mb-6">Votre style, votre identité</span>
        <h2 class="text-5xl md:text-7xl font-serif italic text-white leading-tight mb-10">
            Trouvez votre pièce signature
        </h2>
        <p class="text-gray-400 text-sm mb-12 leading-relaxed max-w-md mx-auto">
            Chaque femme mérite une tenue qui la reflète parfaitement. Découvrez notre catalogue et commandez sur mesure.
        </p>
        <a href="{{ route('catalogue.index') }}" class="group inline-flex items-center gap-4 bg-orange-700 hover:bg-orange-600 text-white px-14 py-6 text-[11px] font-black uppercase tracking-[0.5em] transition-all duration-300 shadow-lg shadow-orange-900/30">
            Explorer le catalogue
            <svg class="w-4 h-4 group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
    </div>
</section>

{{-- ========== STYLES ========== --}}
<style>
/* ---- Fonts & Base ---- */
* { box-sizing: border-box; }

/* ---- Hero Background ---- */
.hero-bg-gradient {
    background: radial-gradient(ellipse 80% 60% at 50% 0%, #3D1F0A 0%, #1A110C 60%, #0D0804 100%);
}

/* ---- Grain Texture ---- */
.grain-overlay {
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 512 512' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='1'/%3E%3C/svg%3E");
    opacity: 0.04;
    pointer-events: none;
}

/* ---- Orbes flottants ---- */
.orb {
    border-radius: 50%;
    filter: blur(80px);
    pointer-events: none;
    animation: float 12s ease-in-out infinite;
}
.orb-1 { width: 500px; height: 500px; background: radial-gradient(circle, rgba(180,60,0,0.25), transparent 70%); top: -100px; left: -100px; animation-delay: 0s; }
.orb-2 { width: 400px; height: 400px; background: radial-gradient(circle, rgba(120,40,0,0.2), transparent 70%); bottom: -50px; right: -50px; animation-delay: 3s; }
.orb-3 { width: 300px; height: 300px; background: radial-gradient(circle, rgba(200,80,0,0.15), transparent 70%); top: 40%; left: 40%; animation-delay: 6s; }
.orb-cta-1 { width: 600px; height: 600px; background: radial-gradient(circle, rgba(180,60,0,0.2), transparent 70%); top: -200px; right: -200px; animation-delay: 0s; }
.orb-cta-2 { width: 400px; height: 400px; background: radial-gradient(circle, rgba(120,40,0,0.15), transparent 70%); bottom: -100px; left: -100px; animation-delay: 4s; }

@keyframes float {
    0%, 100% { transform: translate(0, 0) scale(1); }
    33% { transform: translate(30px, -30px) scale(1.05); }
    66% { transform: translate(-20px, 20px) scale(0.95); }
}

/* ---- Ticker ---- */
.ticker-track {
    animation: ticker 30s linear infinite;
}
@keyframes ticker {
    from { transform: translateX(0); }
    to { transform: translateX(-50%); }
}
.ticker-track:hover { animation-play-state: paused; }

/* ---- Scroll line ---- */
.scroll-line {
    animation: scrollDown 2s ease-in-out infinite;
}
@keyframes scrollDown {
    0% { transform: scaleY(0); transform-origin: top; }
    50% { transform: scaleY(1); transform-origin: top; }
    51% { transform: scaleY(1); transform-origin: bottom; }
    100% { transform: scaleY(0); transform-origin: bottom; }
}

/* ---- Reveal animations ---- */
.reveal-up {
    opacity: 0;
    transform: translateY(40px);
    animation: revealUp 0.9s cubic-bezier(0.22, 1, 0.36, 1) forwards;
}
@keyframes revealUp {
    to { opacity: 1; transform: translateY(0); }
}

.scroll-reveal {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.8s ease, transform 0.8s cubic-bezier(0.22, 1, 0.36, 1);
}
.scroll-reveal.visible {
    opacity: 1;
    transform: translateY(0);
}

/* ---- Catalogue Grid ---- */
.catalogue-grid {
    display: grid;
    grid-template-columns: repeat(12, 1fr);
    gap: 2rem 3rem;
}

/* ---- Stroke text ---- */
.stroke-text {
    -webkit-text-stroke: 1px #c2410c;
    color: transparent;
}

/* ---- Responsive ---- */
@media (max-width: 768px) {
    .catalogue-grid { gap: 3rem 1rem; }
    .orb { display: none; }
    .stroke-text { -webkit-text-stroke: 1px #c2410c; color: transparent; }
}
</style>

{{-- ========== SCRIPTS ========== --}}
<script>
// Intersection Observer pour scroll reveal
document.addEventListener('DOMContentLoaded', () => {
    const reveals = document.querySelectorAll('.scroll-reveal');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -60px 0px' });

    reveals.forEach(el => observer.observe(el));
});
</script>

@endsection