<nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-orange-100"
     x-data="cartSystem()"
     @add-to-cart.window="addItem($event.detail)">

    <div class="max-w-7xl mx-auto px-6 lg:px-12">
        <div class="flex justify-between h-20 items-center">
            <div class="text-2xl font-serif font-bold tracking-widest uppercase italic">
                Ma-Mode<span class="text-orange-700">.</span>
            </div>

            <div class="hidden md:flex space-x-10 text-sm font-medium uppercase tracking-widest">
                {{-- Nos Pièces --}}
                <a href="{{ route('catalogue.index')}}" 
                class="hover:text-orange-700 transition {{ request()->routeIs('catalogue.index') ? 'font-bold border-b-2 border-orange-700 text-orange-700' : '' }}">
                Nos Pièces
                </a>

                {{-- Nos Collections --}}
                <a href="{{ route('collections.index')}}" 
                class="hover:text-orange-700 transition {{ request()->routeIs('collections.index') ? 'font-bold border-b-2 border-orange-700 text-orange-700' : '' }}">
                Nos Collections
                </a>

                @auth
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" 
                        class="hover:text-orange-700 transition {{ request()->routeIs('admin.*') ? 'font-bold border-b-2 border-orange-700 text-orange-700' : '' }}">
                        Administration
                        </a>
                    @elseif(Auth::user()->role === 'styliste')
                        {{-- Atelier (Styliste) --}}
                        <a href="{{ route('styliste.dashboard') }}" 
                        class="hover:text-orange-700 transition {{ request()->routeIs('styliste.dashboard') ? 'font-bold border-b-2 border-orange-700 text-orange-700' : '' }}">
                        Atelier
                        </a>
                    @else
                        {{-- Mes Commandes (Client) --}}
                        <a href="{{ route('commandes.index') }}" 
                        class="hover:text-orange-700 transition {{ request()->routeIs('commandes.index') ? 'font-bold border-b-2 border-orange-700 text-orange-700' : '' }}">
                        Mes Commandes
                        </a>
                    @endif
                @else
                    {{-- Atelier (Non connecté) --}}
                    <a @click="openLoginModal = true" class="cursor-pointer hover:text-orange-700 transition">
                    Atelier
                    </a>
                @endauth
            </div>

            <div class="flex items-center space-x-6">
                <div x-data="{ showSearch: false }">
                    <button @click="showSearch = !showSearch" class="text-xl hover:text-orange-700 transition-colors">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                    <div x-show="showSearch" x-cloak class="absolute inset-x-0 top-20 bg-white p-4 shadow-xl border-b border-orange-100">
                        <form action="{{ route('catalogue.index') }}" method="GET" class="max-w-3xl mx-auto flex items-center">
                            <input type="text" name="search" placeholder="Rechercher..." class="w-full border-none focus:ring-0 text-xl font-serif italic">
                            <button @click="showSearch = false" type="button"><i class="fa-solid fa-xmark"></i></button>
                        </form>
                    </div>
                </div>

                @auth
                    <div class="flex items-center space-x-4">
                        <span class="text-[10px] uppercase tracking-widest text-gray-400 font-bold hidden lg:block">
                            {{ Auth::user()->name }}
                        </span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-[10px] uppercase tracking-widest font-bold text-red-800 hover:text-red-600 transition">
                                Déconnexion
                            </button>
                        </form>
                    </div>
                @else
                    <button @click="openLoginModal = true" class="text-[10px] uppercase tracking-widest font-bold hover:text-orange-700 transition">
                        Connexion
                    </button>
                @endauth

                <button @click="openCart = true" class="text-xl hover:text-orange-700 relative transition-colors">
                    <i class="fa-solid fa-bag-shopping"></i>
                    <span class="absolute -top-2 -right-2 bg-orange-700 text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center font-bold"
                          x-show="items.length > 0" x-text="items.length"></span>
                </button>
            </div>
        </div>
    </div>
    <div x-show="openCart || openLoginModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/60 z-[60] backdrop-blur-sm"
         x-cloak @click="openCart = false; openLoginModal = false"></div>

    <div x-show="openCart"
         x-transition:enter="transition ease-out duration-500 transform"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-300 transform"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         class="fixed right-0 inset-y-0 h-screen w-full max-w-md bg-white z-[70] flex flex-col shadow-[-20px_0_50px_rgba(0,0,0,0.2)] border-l border-orange-100"
         x-cloak>

        <div class="p-8 bg-white border-b border-orange-50 flex justify-between items-center flex-shrink-0">
            <div>
                <h2 class="text-2xl font-serif italic text-[#2D241E]">Votre Sélection</h2>
                <div class="h-0.5 w-10 bg-orange-700 mt-2"></div>
            </div>
            <div class="flex items-center space-x-2">
                <button x-show="items.length > 0"
                        @click="confirmClearCart()"
                        class="text-[10px] uppercase tracking-widest text-red-400 hover:text-red-700 transition-colors font-bold mr-4">
                    Vider
                </button>
                <button @click="openCart = false" class="p-2 hover:bg-orange-50 rounded-full transition-colors group">
                    <i class="fa-solid fa-xmark text-xl text-gray-400 group-hover:text-black group-hover:rotate-90 transition-all duration-300"></i>
                </button>

            </div>
        </div>

        <div class="flex-1 overflow-y-auto p-8 bg-white custom-scrollbar">
            <template x-if="items.length === 0">
                <div class="h-full flex flex-col items-center justify-center text-gray-400 space-y-4">
                    <i class="fa-solid fa-bag-shopping text-5xl opacity-10"></i>
                    <p class="font-serif italic text-lg">Votre panier est vide</p>
                </div>
            </template>

            <div class="space-y-8">
                <template x-for="item in items" :key="item.id">
                    <div class="flex gap-6 group">
                        <div class="relative w-24 h-32 flex-shrink-0 overflow-hidden shadow-sm border border-gray-50">
                            <img :src="item.image" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 flex flex-col justify-between py-1">
                            <div>
                                <div class="flex justify-between items-start">
                                    <h3 class="font-serif text-lg text-[#2D241E]" x-text="item.nom"></h3>
                                    <button @click="removeItem(item.id)" class="text-gray-300 hover:text-red-700 transition-colors">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>
                                </div>
                                <p class="text-[10px] text-gray-400 uppercase tracking-widest mt-1 italic">Pièce Artisanale</p>
                            </div>
                            <p class="font-bold text-[#2D241E]" x-text="item.prix.toLocaleString() + ' FCFA'"></p>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <div class="p-8 bg-gray-50 border-t border-orange-100 flex-shrink-0">
            <div class="flex justify-between items-center mb-6">
                <span class="text-xs uppercase tracking-[0.2em] text-gray-500 font-bold">Total Estimation</span>
                <span class="text-2xl font-serif text-[#2D241E] font-bold" x-text="getTotal() + ' FCFA'"></span>
            </div>

            <div class="space-y-3">
                @auth
                    <button @click="submitOrder()" class="w-full bg-[#2D241E] text-white py-5 font-bold uppercase tracking-[0.2em] text-xs hover:bg-black transition-all shadow-lg shadow-[#2D241E]/10">
                        Finaliser la commande
                    </button>
                @else
                    <button @click="openLoginModal = true; openCart = false" class="w-full bg-orange-700 text-white py-5 font-bold uppercase tracking-[0.2em] text-xs hover:bg-orange-800 transition-all shadow-lg shadow-orange-700/20">
                        Se connecter pour commander
                    </button>

                @endauth
                <button @click="openCart = false" class="w-full text-[10px] uppercase tracking-[0.2em] text-gray-400 font-bold hover:text-black pt-2 transition-colors">
                    ← Continuer mes achats
                </button>
            </div>
        </div>
    </div>

    <div x-show="openLoginModal" x-cloak class="fixed inset-0 z-[9999] flex items-center justify-center" style="backdrop-filter: blur(4px); background-color: rgba(0,0,0,0.6);">
        <div @click="openLoginModal = false" class="absolute inset-0"></div>
        <div class="relative bg-white w-[90%] max-w-md shadow-2xl border border-orange-100 flex flex-col" style="max-height: 90vh; margin: auto;">
            <button @click="openLoginModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-black z-50 p-2">
                <i class="fa-solid fa-xmark text-2xl"></i>
            </button>
            <div class="p-8 sm:p-12 overflow-y-auto">
                <div class="text-center mb-10">
                    <h2 class="text-3xl font-serif italic text-[#2D241E]">Bienvenue</h2>
                    <div class="h-0.5 w-10 bg-orange-700 mx-auto mt-2"></div>
                </div>
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label class="text-[10px] uppercase font-bold tracking-widest text-gray-400">Email</label>
                        <input type="email" name="email" required class="w-full border-0 border-b border-orange-200 focus:ring-0 focus:border-orange-700 px-0 py-2">
                    </div>
                    <div>
                        <label class="text-[10px] uppercase font-bold tracking-widest text-gray-400">Mot de passe</label>
                        <input type="password" name="password" required class="w-full border-0 border-b border-orange-200 focus:ring-0 focus:border-orange-700 px-0 py-2">
                    </div>
                    <button type="submit" class="w-full bg-[#2D241E] text-white py-4 font-bold uppercase tracking-widest text-xs hover:bg-black transition-all">Se Connecter</button>
                    <div class="mt-8 pt-6 border-t border-orange-50 text-center">
                        <p class="text-[10px] uppercase tracking-widest text-gray-400 mb-4">Pas encore de compte ?</p>
                        <a href="{{ route('inscription') }}" class="text-xs font-bold uppercase tracking-widest text-orange-700 hover:text-orange-800">
                            Créer mon compte client
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</nav>

<script>
    function cartSystem() {
        return {
            openCart: false,
            openLoginModal: false,
            items: JSON.parse(localStorage.getItem('cart') || '[]'),

            init() {
                this.$watch('openCart || openLoginModal', value => {
                    document.body.style.overflow = value ? 'hidden' : 'auto';
                });
            },

            addItem(item) {
                if(!item || !item.id) return;
                const exists = this.items.find(i => i.id === item.id);
                if (!exists) {
                    this.items.push({ ...item, quantity: 1 });
                }
                this.save();
                this.openCart = true;
            },

            removeItem(id) {
                this.items = this.items.filter(i => i.id !== id);
                this.save();
            },
            confirmClearCart() {
            // On vérifie si Swal est chargé pour éviter une erreur console
            if (typeof Swal === 'undefined') {
                if(confirm('Vider le panier ?')) this.clearCart();
                return;
            }

            Swal.fire({
                title: 'Vider le panier ?',
                text: "Tous vos articles sélectionnés seront retirés.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#2D241E', // Ta couleur sombre
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, vider',
                cancelButtonText: 'Annuler',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    this.clearCart();

                    // Toast de confirmation discret
                    Swal.fire({
                        title: 'Panier vidé',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                }
            });
        },
            // NOUVELLE FONCTION POUR VIDER LE PANIER
            clearCart() {
                this.items = [];
                this.save();
            },

            save() {
                localStorage.setItem('cart', JSON.stringify(this.items));
            },

            getTotal() {
                const total = this.items.reduce((sum, item) => sum + item.prix, 0);
                return total.toLocaleString();
            },

           submitOrder() {
                if (this.items.length === 0) {
                    alert("Votre panier est vide");
                    return;
                }
                // Redirection simple : la page suivante lira toute seule le localStorage
                window.location.href = "{{ route('commande.validation') }}";
            }

        }
    }
</script>

<style>
    [x-cloak] { display: none !important; }

    /* Scrollbar minimaliste pour le panier */
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #fff; }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #fed7aa;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #ea580c; }
</style>
