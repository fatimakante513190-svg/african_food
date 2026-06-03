<x-app-layout>
    <!-- Hero Section avec image de fond -->
    <div class="relative bg-gradient-to-r from-red-600 to-red-800 text-white">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">🍽️ Notre Carte</h1>
            <p class="text-xl md:text-2xl opacity-90">Découvrez nos délicieux plats préparés avec passion</p>
            @guest
                <div class="mt-6">
                    <a href="{{ route('login') }}" 
                       class="inline-flex items-center bg-white text-red-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                        🔐 Se connecter pour commander
                    </a>
                </div>
            @endguest
        </div>
    </div>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
           
            <!-- Affichage par catégorie -->
            @foreach($categories as $category)
                <div class="mb-12">
                    <!-- En-tête de catégorie avec icône -->
                    <div class="flex items-center mb-6">
                        <div class="h-1 w-12 bg-red-600 rounded-full"></div>
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 ml-4">
                            {{ $category->name }}
                        </h2>
                        <div class="flex-1 h-1 bg-gradient-to-r from-red-200 to-transparent ml-4 rounded-full"></div>
                    </div>
                   
                    <!-- Grille produits responsive -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($category->products as $product)
                            <!-- Card produit moderne -->
                            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                                <!-- Image du produit -->
                                <div class="relative h-48 overflow-hidden bg-gray-200">
                                    @if($product->image && Storage::disk('public')->exists($product->image))
                                        <img src="{{ Storage::url($product->image) }}" 
                                             alt="{{ $product->name }}" 
                                             class="w-full h-full object-cover transition duration-300 hover:scale-110">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                                            <span class="text-6xl opacity-50">
                                                @switch($category->name)
                                                    @case('Entrées') 🥗 @break
                                                    @case('Plats principaux') 🍖 @break
                                                    @case('Desserts') 🍰 @break
                                                    @case('Boissons') 🥤 @break
                                                    @case('Cocktails') 🍹 @break
                                                    @default 🍽️
                                                @endswitch
                                            </span>
                                        </div>
                                    @endif
                                    
                                    <!-- Badge stock -->
                                    @if($product->stock < 5 && $product->stock > 0)
                                        <div class="absolute top-2 right-2 bg-orange-500 text-white text-xs px-2 py-1 rounded-full">
                                            Plus que {{ $product->stock }}
                                        </div>
                                    @elseif($product->stock == 0)
                                        <div class="absolute top-2 right-2 bg-red-600 text-white text-xs px-2 py-1 rounded-full">
                                            Rupture
                                        </div>
                                    @endif
                                </div>

                                <!-- Contenu de la card -->
                                <div class="p-4">
                                    <h3 class="font-bold text-lg text-gray-800 mb-1 line-clamp-1">{{ $product->name }}</h3>
                                    
                                    <p class="text-gray-600 text-sm mb-3 line-clamp-2 min-h-[40px]">
                                        {{ $product->description ?? 'Aucune description' }}
                                    </p>
                                    
                                    <!-- Prix et actions -->
                                    <div class="flex items-center justify-between mt-3">
                                        <div>
                                            <span class="text-2xl font-bold text-red-600">{{ number_format($product->price, 2) }}</span>
                                            <span class="text-gray-500 text-sm">€</span>
                                        </div>
                                        
                                        @auth
                                            @if($product->stock > 0)
                                                <form action="{{ route('order.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="table_number" value="{{ session('table_number', 1) }}">
                                                    <input type="hidden" name="items[0][product_id]" value="{{ $product->id }}">
                                                    <input type="hidden" name="items[0][quantity]" value="1">
                                                    
                                                    <button type="submit"
                                                            class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-lg transition flex items-center gap-2">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6M17 13l1.5 6M9 21h6M12 18v3"></path>
                                                        </svg>
                                                        Commander
                                                    </button>
                                                </form>
                                            @else
                                                <button disabled
                                                        class="bg-gray-300 text-gray-500 font-semibold px-4 py-2 rounded-lg cursor-not-allowed">
                                                    Indisponible
                                                </button>
                                            @endif
                                        @else
                                            <a href="{{ route('login') }}" 
                                               class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold px-4 py-2 rounded-lg transition">
                                                🔐 Commander
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
           
            <!-- Section appel à l'action pour les non connectés -->
            @guest
                <div class="text-center py-12">
                    <div class="bg-white rounded-xl shadow-lg p-8 max-w-2xl mx-auto">
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Envie de commander ?</h3>
                        <p class="text-gray-600 mb-6">Créez un compte ou connectez-vous pour passer votre commande</p>
                        <div class="flex justify-center gap-4">
                            <a href="{{ route('login') }}" class="bg-red-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-red-700 transition">
                                Se connecter
                            </a>
                            <a href="{{ route('register') }}" class="bg-gray-200 text-gray-800 px-6 py-3 rounded-lg font-semibold hover:bg-gray-300 transition">
                                Créer un compte
                            </a>
                        </div>
                    </div>
                </div>
            @endguest
        </div>
    </div>
</x-app-layout>