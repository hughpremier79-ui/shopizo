<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{
    public function index()
    {
        $store = Auth::user()->store;
        return view('vendor.store.index', compact('store'));
    }

    public function create()
    {
        return view('vendor.store.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'whatsapp_number' => 'required|string|max:20',
            'city' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        $slug = Str::slug($request->name);
        $count = Store::where('slug', 'like', $slug.'%')->count();
        if ($count > 0) {
            $slug = $slug.'-'.($count + 1);
        }

        Store::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'whatsapp_number' => $request->whatsapp_number,
            'city' => $request->city,
            'address' => $request->address,
            'logo' => $logoPath,
            'status' => 'active',
        ]);

        return redirect('/vendor/store')->with('success', 'Boutique creee !');
    }

    public function edit()
    {
        $store = Auth::user()->store;
        return view('vendor.store.edit', compact('store'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'whatsapp_number' => 'required|string|max:20',
            'city' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'facebook' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'tiktok' => 'nullable|string|max:255',
        ]);

        $store = Auth::user()->store;
        $logoPath = $store->logo;

        if ($request->hasFile('logo')) {
            if ($store->logo) {
                Storage::disk('public')->delete($store->logo);
            }
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        $store->update([
            'name' => $request->name,
            'description' => $request->description,
            'whatsapp_number' => $request->whatsapp_number,
            'city' => $request->city,
            'address' => $request->address,
            'logo' => $logoPath,
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'tiktok' => $request->tiktok,
        ]);

        return redirect('/vendor/store')->with('success', 'Boutique mise a jour !');
    }
}