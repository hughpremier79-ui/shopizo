<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()->store->orders()->with('product')->latest()->get();
        return view('vendor.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('product', 'statusHistories.user');
        return view('vendor.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,processing,delivered,cancelled',
        ]);

        $oldStatus = $order->status;
        $order->update(['status' => $request->status]);

        OrderStatusHistory::create([
            'order_id' => $order->id,
            'old_status' => $oldStatus,
            'new_status' => $request->status,
            'changed_by' => Auth::id(),
        ]);

        return redirect('/vendor/orders/'.$order->id)->with('success', 'Statut mis a jour !');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'client_name' => 'required|string|max:255',
            'client_phone' => 'required|string|max:20',
            'client_area' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string',
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity;
        $unitPrice = $product->price;
        $totalPrice = $unitPrice * $quantity;

        $source = $request->source ?? session('source', 'direct');
        session()->forget('source');

        $order = Order::create([
            'store_id' => $product->store_id,
            'product_id' => $product->id,
            'client_name' => $request->client_name,
            'client_phone' => $request->client_phone,
            'client_area' => $request->client_area,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total_price' => $totalPrice,
            'note' => $request->note,
            'source' => $source,
            'status' => 'pending',
        ]);

        $whatsappNumber = $product->store->whatsapp_number;
        $message = "Bonjour, je veux commander :\n";
        $message .= "Produit : {$product->name}\n";
        $message .= "Prix : {$unitPrice} FCFA\n";
        $message .= "Quantite : {$quantity}\n";
        $message .= "Total : {$totalPrice} FCFA\n";
        $message .= "Nom : {$request->client_name}\n";
        $message .= "Quartier : {$request->client_area}\n";
        $message .= "Telephone : {$request->client_phone}";

        $whatsappUrl = "https://wa.me/{$whatsappNumber}?text=".urlencode($message);

        return redirect($whatsappUrl);
    }
}