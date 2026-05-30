<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-6">Modifier le produit</h1>

                    <form action="{{ route('admin.products.update', $product) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nom du produit</label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}"
                                   class="shadow appearance-none border rounded w-full py-2 px-3" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Catégorie</label>
                            <select name="category_id" class="shadow appearance-none border rounded w-full py-2 px-3" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                            <textarea name="description" rows="3"
                                      class="shadow appearance-none border rounded w-full py-2 px-3">{{ old('description', $product->description) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Prix (€)</label>
                            <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Stock</label>
                            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}">
                        </div>

                        <div class="flex justify-end">
                            <a href="{{ route('admin.products.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Annuler</a>
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Mettre à jour</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>