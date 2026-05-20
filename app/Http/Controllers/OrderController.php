<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
// Enregistrer une commande
public function store(Request $request)
{
$request->validate([
'table_number' => 'required|integer',
'items' => 'required|array',
'items.*.product_id' => 'exists:products,id',
'items.*.quantity' => 'integer|min:1'
]);

$total = 0;
$itemsData = [];

// Calcul du total
foreach ($request->items as $item) {
$product = Product::find($item['product_id']);
$itemTotal = $product->price * $item['quantity'];
$total += $itemTotal;
$itemsData[] = [
'product_id' => $product->id,
'quantity' => $item['quantity'],
'unit_price' => $product->price
];
}

// Création de la commande dans une transaction
DB::transaction(function () use ($request, $total, $itemsData) {
$order = Order::create([
'user_id' => auth()->id(),
'status' => 'en_attente',
'total' => $total,
'table_number' => $request->table_number
]);

foreach ($itemsData as $item) {
$order->items()->create($item);
}
});

return redirect()->route('order.history')->with('success', 'Commande envoyée à la cuisine !');
}

// Historique des commandes du client
public function history()
{
$orders = Order::with('items.product')
->where('user_id', auth()->id())
->orderBy('created_at', 'desc')
->get();

return view('orders.history', compact('orders'));
}

// Vue staff : toutes les commandes
public function staffIndex()
{
    // Récupère toutes les commandes avec les relations
    $orders = Order::with(['items.product', 'user'])
                   ->orderBy('created_at', 'desc')
                   ->get();
   
    return view('staff.orders', compact('orders'));
}

// Changer le statut d'une commande
public function updateStatus($id, Request $request)
{
    $request->validate([
        'status' => 'required|in:en_attente,preparation,servi'
    ]);
   
    $order = Order::findOrFail($id);
    $order->status = $request->status;
    $order->save();
   
    return back()->with('success', 'Statut de la commande mis à jour');
}


}
