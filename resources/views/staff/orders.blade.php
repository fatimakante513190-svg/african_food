<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
           
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
               
                <!-- Colonne En attente -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 bg-orange-100 border-b">
                        <h2 class="text-xl font-bold text-orange-700">⏳ En attente</h2>
                    </div>
                    <div class="p-4 space-y-4">
                        @php $enAttente = $orders->where('status', 'en_attente'); @endphp
                        @forelse($enAttente as $order)
                            <div class="border rounded-lg p-3 bg-white">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-bold">Commande #{{ $order->id }}</p>
                                        <p class="text-sm">Table {{ $order->table_number }}</p>
                                        <p class="text-sm text-gray-600">Par {{ $order->user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</p>
                                    </div>
                                    <p class="font-bold text-green-600">{{ number_format($order->total, 2) }} €</p>
                                </div>
                               
                                <!-- Détail des produits -->
                                <div class="mt-2 pt-2 border-t">
                                    <ul class="text-sm">
                                        @foreach($order->items as $item)
                                            <li>{{ $item->quantity }} x {{ $item->product->name }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                               
                                <!-- Formulaire changement statut -->
                                <form action="{{ route('staff.update-status', $order->id) }}" method="POST" class="mt-3">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" onchange="this.form.submit()"
                                            class="w-full border rounded px-2 py-1 text-sm">
                                        <option value="en_attente" selected>📋 En attente</option>
                                        <option value="preparation">🔪 En préparation</option>
                                        <option value="servi">✅ Servi</option>
                                    </select>
                                </form>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">Aucune commande</p>
                        @endforelse
                    </div>
                </div>

                <!-- Colonne En préparation -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 bg-blue-100 border-b">
                        <h2 class="text-xl font-bold text-blue-700">🔪 En préparation</h2>
                    </div>
                    <div class="p-4 space-y-4">
                        @php $preparation = $orders->where('status', 'preparation'); @endphp
                        @forelse($preparation as $order)
                            <div class="border rounded-lg p-3 bg-white">
                                <div class="flex justify-between">
                                    <p class="font-bold">Commande #{{ $order->id }}</p>
                                    <p class="text-sm">Table {{ $order->table_number }}</p>
                                </div>
                               
                                <form action="{{ route('staff.update-status', $order->id) }}" method="POST" class="mt-3">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" onchange="this.form.submit()"
                                            class="w-full border rounded px-2 py-1 text-sm">
                                        <option value="en_attente">📋 En attente</option>
                                        <option value="preparation" selected>🔪 En préparation</option>
                                        <option value="servi">✅ Servi</option>
                                    </select>
                                </form>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">Aucune commande</p>
                        @endforelse
                    </div>
                </div>

                <!-- Colonne Servi -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 bg-green-100 border-b">
                        <h2 class="text-xl font-bold text-green-700">✅ Servis</h2>
                    </div>
                    <div class="p-4 space-y-4">
                        @php $servi = $orders->where('status', 'servi'); @endphp
                        @forelse($servi as $order)
                            <div class="border rounded-lg p-3 bg-white opacity-75">
                                <div class="flex justify-between">
                                    <p class="font-bold">Commande #{{ $order->id }}</p>
                                    <p class="text-sm">Table {{ $order->table_number }}</p>
                                </div>
                                <p class="text-xs text-gray-500">{{ $order->updated_at->format('H:i') }}</p>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">Aucune commande</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

