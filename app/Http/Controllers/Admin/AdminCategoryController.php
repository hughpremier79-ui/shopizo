<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => 'active',
        ]);

        return redirect('/admin/categories')->with('success', 'Categorie creee !');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect('/admin/categories')->with('success', 'Categorie supprimee !');
    }
}