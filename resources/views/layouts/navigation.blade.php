<nav class="bg-gradient-to-r from-amber-800 to-orange-700 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <span class="text-2xl">🍛</span>
                    <span class="text-xl font-bold text-white">AFRICAN FOOD</span>
                </a>
            </div>

            <!-- Liens de navigation selon le rôle -->
            <div class="hidden md:flex items-center space-x-6">
                <!-- Carte : TOUT LE MONDE voit -->
                <a href="{{ route('home') }}" class="text-white hover:text-amber-200 transition">🍽️ Carte</a>
                
                <!-- CLIENT uniquement : Mes commandes -->
                @auth
                    @if(auth()->user()->isClient())
                        <a href="{{ route('order.history') }}" class="text-white hover:text-amber-200 transition">📜 Mes commandes</a>
                    @endif
                @endauth
                
                <!-- ADMIN uniquement : Produits + Commandes -->
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.products.index') }}" class="text-white hover:text-amber-200 transition">📦 Produits</a>
                        <a href="{{ route('staff.orders') }}" class="text-white hover:text-amber-200 transition">👨‍🍳 Commandes</a>
                    @endif
                @endauth
                
                <!-- SERVEUR uniquement : Commandes avec badge -->
                @auth
                    @if(auth()->user()->isServeur() || auth()->user()->isAdmin())
                        <div x-data="{ pendingCount: 0 }" x-init="
                            fetch('{{ route('api.pending-count') }}')
                                .then(res => res.json())
                                .then(data => pendingCount = data.count);
                            
                            setInterval(() => {
                                fetch('{{ route('api.pending-count') }}')
                                    .then(res => res.json())
                                    .then(data => pendingCount = data.count);
                            }, 5000);
                        ">
                            <a href="{{ route('staff.orders') }}" class="text-white hover:text-amber-200 transition flex items-center space-x-1">
                                <span>👨‍🍳 Commandes</span>
                                <span x-show="pendingCount > 0" x-text="pendingCount" 
                                    class="bg-red-500 text-white text-xs font-bold rounded-full px-2 py-0.5 ml-1 animate-pulse">
                                </span>
                            </a>
                        </div>
                    @endif
                @endauth

                <!-- CUISINE uniquement : Préparations avec badge -->
                @auth
                    @if(auth()->user()->isCuisine())
                        <div x-data="{ preparingCount: 0 }" x-init="
                            fetch('/api/preparing-count')
                                .then(res => res.json())
                                .then(data => preparingCount = data.count);
                            
                            setInterval(() => {
                                fetch('/api/preparing-count')
                                    .then(res => res.json())
                                    .then(data => preparingCount = data.count);
                            }, 5000);
                        ">
                            <a href="{{ route('cuisine.orders') }}" class="text-white hover:text-amber-200 transition flex items-center space-x-1">
                                <span>🍳 Préparations</span>
                                <span x-show="preparingCount > 0" x-text="preparingCount" 
                                    class="bg-red-500 text-white text-xs font-bold rounded-full px-2 py-0.5 ml-1 animate-pulse">
                                </span>
                            </a>
                        </div>
                    @endif
                @endauth
            </div>

            <!-- Menu utilisateur -->
            <div class="flex items-center space-x-4">
                @auth
                    <div class="relative">
                        <div class="flex items-center space-x-2 text-white">
                            <span>{{ Auth::user()->name }}</span>
                            <span>👤</span>
                            <a href="{{ route('profile.edit') }}" class="text-sm text-amber-200 hover:text-white">Profil</a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-sm text-red-300 hover:text-white">Déconnexion</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-white hover:text-amber-200">Connexion</a>
                    <a href="{{ route('register') }}" class="bg-amber-600 text-white px-4 py-2 rounded-lg hover:bg-amber-700">Inscription</a>
                @endauth
            </div>
        </div>
    </div>
</nav>