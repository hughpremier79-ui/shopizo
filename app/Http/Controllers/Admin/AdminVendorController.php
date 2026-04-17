<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminVendorController extends Controller
{
    public function index()
    {
        $vendors = User::where('role', 'vendor')->with('store')->latest()->get();
        return view('admin.vendors.index', compact('vendors'));
    }

    public function show(User $user)
    {
        $user->load('store.products', 'store.orders');
        return view('admin.vendors.show', compact('user'));
    }

    public function suspend(User $user)
    {
        $user->update(['status' => 'suspended']);
        return redirect('/admin/vendors')->with('success', 'Vendeur suspendu !');
    }

    public function activate(User $user)
    {
        $user->update(['status' => 'active']);
        return redirect('/admin/vendors')->with('success', 'Vendeur active !');
    }

    public function updatePlan(Request $request, User $user)
    {
        $request->validate([
            'plan' => 'required|in:free,standard,premium',
            'plan_expires_at' => 'required|date',
        ]);

        $user->update([
            'plan' => $request->plan,
            'plan_expires_at' => $request->plan_expires_at,
        ]);

        return redirect('/admin/vendors')->with('success', 'Plan mis a jour !');
    }
}