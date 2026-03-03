<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ASSIAT | La mode autrement</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:wght@200..800&display=swap');
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
            .font-serif { font-family: 'Playfair Display', serif; }
            .hover-scale { transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1); }
            .hover-scale:hover { transform: scale(1.03); }
            [x-cloak] {
    display: none !important;
}
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#FDFBF7] text-[#2D241E]">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                @yield('content')
            </main>
        </div>
    </body>
    <footer class="bg-[#2D241E] text-[#FDFBF7] pt-20 pb-10 mt-20">
        <div class="max-w-7xl mx-auto px-6 lg:px-12 grid grid-cols-1 md:grid-cols-4 gap-12 border-b border-white/10 pb-16">
            <div class="col-span-1 md:col-span-1">
                <div class="text-2xl font-serif font-bold tracking-widest uppercase mb-6">Assiat Mode<span class="text-orange-400">.</span></div>
                <p class="text-sm text-gray-400 leading-relaxed">Redéfinir l'élégance africaine à travers l'artisanat et des textiles d'exception.</p>
            </div>
            <div>
                <h4 class="font-bold mb-6 uppercase tracking-widest text-sm">Boutique</h4>
                <ul class="space-y-4 text-sm text-gray-400">
                    <li><a href="#" class="hover:text-white transition">Nouveautés</a></li>
                    <li><a href="#" class="hover:text-white transition">Prêt-à-porter</a></li>
                    <li><a href="#" class="hover:text-white transition">Sur mesure</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-6 uppercase tracking-widest text-sm">Aide</h4>
                <ul class="space-y-4 text-sm text-gray-400">
                    <li><a href="#" class="hover:text-white transition">Livraison & Retours</a></li>
                    <li><a href="#" class="hover:text-white transition">Guide des tailles</a></li>
                    <li><a href="#" class="hover:text-white transition">Contact</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-6 uppercase tracking-widest text-sm">Newsletter</h4>
                <div class="flex">
                    <input type="email" placeholder="Votre email" class="bg-transparent border-b border-gray-600 focus:border-orange-400 outline-none pb-2 w-full text-sm">
                    <button class="ml-4 border-b border-gray-600 hover:text-orange-400 transition pb-2 underline uppercase text-[10px]">S'inscrire</button>
                </div>
            </div>
        </div>
        <div class="text-center pt-10 text-[10px] text-gray-500 uppercase tracking-[0.2em]">
            &copy; 2026 Assiat Couture - Tous droits réservés.
        </div>
    </footer>
</html>

