<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold">Gestion des produits</h1>
                        <a href="{{ route('admin.products.create') }}"
                           class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            + Ajouter un produit
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="min-w-full table-auto">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 text-left">Image</th>
                                <th class="px-4 py-2 text-left">Nom</th>
                                <th class="px-4 py-2 text-left">Catégorie</th>
                                <th class="px-4 py-2 text-left">Prix</th>
                                <th class="px-4 py-2 text-left">Stock</th>
                                <th class="px-4 py-2 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr class="border-b">
                                <td class="px-4 py-2">
                                    @if($product->image)
                                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="h-12 w-12 object-cover rounded">
                                    @else
                                        <div class="h-12 w-12 bg-gray-200 rounded flex items-center justify-center">
                                            <span class="text-gray-400 text-xs">Pas d'image</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-2">{{ $product->name }}</td>
                                <td class="px-4 py-2">{{ $product->category->name }}</td>
                                <td class="px-4 py-2">{{ $product->price }} €</td>
                                <td class="px-4 py-2">{{ $product->stock }}</td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('admin.products.edit', $product) }}"
                                       class="text-blue-500 hover:text-blue-700 mr-2">Modifier</a>
                                    <form action="{{ route('admin.products.destroy', $product) }}"
                                          method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700"
                                                onclick="return confirm('Supprimer ce produit ?')">
                                            Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>