<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Store;

class AdminController extends Controller
{
    public function index()
    {
        $totalVendors = User::where('role', 'vendor')->count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $deliveredOrders = Order::where('status', 'delivered')->count();
        $latestOrders = Order::with('product', 'store')->latest()->take(5)->get();
        $latestVendors = User::where('role', 'vendor')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalVendors',
            'totalProducts',
            'totalOrders',
            'pendingOrders',
            'deliveredOrders',
            'latestOrders',
            'latestVendors'
        ));
    }
}