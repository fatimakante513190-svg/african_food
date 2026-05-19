<x-app-layout>
<div class="py-12">
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

<!-- Message de bienvenue -->
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
<div class="p-6 text-gray-900">
<h1 class="text-3xl font-bold text-center">🍽️ Notre Carte</h1>
<p class="text-center text-gray-600 mt-2">Découvrez nos délicieux plats</p>
</div>
</div>

<!-- Affichage par catégorie -->
@foreach($categories as $category)
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
<div class="p-6">
<h2 class="text-2xl font-bold mb-4 text-gray-800 border-b pb-2">{{ $category->name }}</h2>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
@foreach($category->products as $product)
<div class="border rounded-lg p-4 hover:shadow-lg transition">
<h3 class="font-bold text-lg">{{ $product->name }}</h3>
<p class="text-gray-600 text-sm mt-1">{{ $product->description }}</p>
<p class="text-green-600 font-bold text-xl mt-2">{{ number_format($product->price, 2) }} €</p>

<!-- Formulaire de commande rapide -->
<form action="{{ route('order.store') }}" method="POST" class="mt-3">
@csrf
<input type="hidden" name="table_number" value="1">
<input type="hidden" name="items[0][product_id]" value="{{ $product->id }}">
<input type="hidden" name="items[0][quantity]" value="1">

<button type="submit"
class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
Commander
</button>
</form>
</div>
@endforeach
</div>
</div>
</div>
@endforeach

</div>
</div>
</x-app-layout>
