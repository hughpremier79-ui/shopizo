<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Auth::user()->store->products()->latest()->get();
        return view('vendor.products.index', compact('products'));
    }

    public function create()
    {
        $user = Auth::user();
        if (!$user->canAddProduct()) {
            return redirect('/vendor/products')->with('error', 'Vous avez atteint la limite de 5 produits. Passez au plan Standard ou Premium pour ajouter plus de produits.');
        }
        $categories = Category::where('status', 'active')->get();
        return view('vendor.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->canAddProduct()) {
            return redirect('/vendor/products')->with('error', 'Limite atteinte. Passez au plan payant pour ajouter plus de produits.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'stock' => 'required|integer',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $slug = Str::slug($request->name);
        $count = Product::where('slug', 'like', $slug.'%')->count();
        if ($count > 0) {
            $slug = $slug.'-'.($count + 1);
        }

        Product::create([
            'store_id' => Auth::user()->store->id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => $slug,
            'price' => $request->price,
            'description' => $request->description,
            'stock' => $request->stock,
            'image' => $imagePath,
            'status' => 'active',
        ]);

        return redirect('/vendor/products')->with('success', 'Produit ajoute !');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('status', 'active')->get();
        return view('vendor.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'status' => $request->status,
            'image' => $imagePath,
        ]);

        return redirect('/vendor/products')->with('success', 'Produit mis a jour !');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return redirect('/vendor/products')->with('success', 'Produit supprime !');
    }
}