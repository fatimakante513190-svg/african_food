<x-app-layout>
<div class="py-12">
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
<div class="p-6 text-gray-900">
<h1 class="text-2xl font-bold mb-6">📜 Mon historique de commandes</h1>

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
{{ session('success') }}
</div>
@endif

@if($orders->isEmpty())
<p class="text-gray-500 text-center py-8">Vous n'avez pas encore passé de commande.</p>
@else
<div class="space-y-4">
@foreach($orders as $order)
<div class="border rounded-lg p-4">
<div class="flex justify-between items-start">
<div>
<p class="font-bold">Commande #{{ $order->id }}</p>
<p class="text-sm text-gray-600">Table {{ $order->table_number }}</p>
<p class="text-sm text-gray-600">{{ $order->created_at->format('d/m/Y H:i') }}</p>
</div>
<div class="text-right">
<p class="font-bold text-lg">{{ number_format($order->total, 2) }} €</p>
<p class="text-sm">
Statut :
@if($order->status == 'en_attente')
<span class="text-orange-500">⏳ En attente</span>
@elseif($order->status == 'preparation')
<span class="text-blue-500">🔪 En préparation</span>
@else
<span class="text-green-500">✅ Servi</span>
@endif
</p>
</div>
</div>

<!-- Détail des produits commandés -->
<div class="mt-3 pt-3 border-t">
<p class="font-semibold mb-2">Détail :</p>
<ul class="list-disc list-inside">
@foreach($order->items as $item)
<li class="text-sm">
{{ $item->quantity }} x {{ $item->product->name }}
({{ number_format($item->unit_price, 2) }} €)
</li>
@endforeach
</ul>
</div>
</div>
@endforeach
</div>
@endif
</div>
</div>
</div>
</div>
</x-app-layout>
