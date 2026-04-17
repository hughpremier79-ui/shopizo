<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminVendorController;
use App\Http\Controllers\Admin\AdminCategoryController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/p/{slug}', function ($slug) {
    $product = \App\Models\Product::where('slug', $slug)->where('status', 'active')->firstOrFail();
    if (request()->has('source')) {
        session(['source' => request()->get('source')]);
    }
    return view('public.product', compact('product'));
})->name('product.public');

Route::get('/boutique/{slug}', function ($slug) {
    $store = \App\Models\Store::where('slug', $slug)->where('status', 'active')->firstOrFail();
    $products = $store->products()->where('status', 'active')->get();
    return view('public.store', compact('store', 'products'));
})->name('store.public');

Route::get('/tarifs', function () {
    return view('public.pricing');
})->name('pricing');
Route::get('/contact', function () {
    return view('public.contact');
})->name('contact');
Route::get('/avis', function () {
    $reviews = \App\Models\Review::where('status', 'approved')->latest()->get();
    return view('public.reviews', compact('reviews'));
})->name('reviews');

Route::post('/avis', [App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');

Route::middleware(['auth', 'verified'])->group(function () {

   Route::get('/dashboard', function () {
    if (Auth::user()->role === 'admin') {
        return redirect('/admin');
    }
    $store = Auth::user()->store;
    $totalProducts = $store ? $store->products()->count() : 0;
    $totalOrders = $store ? $store->orders()->count() : 0;
    $pendingOrders = $store ? $store->orders()->where('status', 'pending')->count() : 0;
    $deliveredOrders = $store ? $store->orders()->where('status', 'delivered')->count() : 0;
    $latestOrders = $store ? $store->orders()->with('product')->latest()->take(5)->get() : collect();
    return view('dashboard', compact('totalProducts', 'totalOrders', 'pendingOrders', 'deliveredOrders', 'latestOrders'));
})->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/vendor/store', [StoreController::class, 'index'])->name('vendor.store.index');
    Route::get('/vendor/store/create', [StoreController::class, 'create'])->name('vendor.store.create');
    Route::post('/vendor/store', [StoreController::class, 'store'])->name('vendor.store.store');
    Route::get('/vendor/store/edit', [StoreController::class, 'edit'])->name('vendor.store.edit');
    Route::put('/vendor/store', [StoreController::class, 'update'])->name('vendor.store.update');

    Route::get('/vendor/products', [ProductController::class, 'index'])->name('vendor.products.index');
    Route::get('/vendor/products/create', [ProductController::class, 'create'])->name('vendor.products.create');
    Route::post('/vendor/products', [ProductController::class, 'store'])->name('vendor.products.store');
    Route::get('/vendor/products/{product}/edit', [ProductController::class, 'edit'])->name('vendor.products.edit');
    Route::put('/vendor/products/{product}', [ProductController::class, 'update'])->name('vendor.products.update');
    Route::delete('/vendor/products/{product}', [ProductController::class, 'destroy'])->name('vendor.products.destroy');

    Route::get('/vendor/orders', [OrderController::class, 'index'])->name('vendor.orders.index');
    Route::get('/vendor/orders/{order}', [OrderController::class, 'show'])->name('vendor.orders.show');
    Route::post('/vendor/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('vendor.orders.status');

    Route::prefix('admin')->middleware('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/vendors', [AdminVendorController::class, 'index'])->name('admin.vendors.index');
        Route::get('/vendors/{user}', [AdminVendorController::class, 'show'])->name('admin.vendors.show');
        Route::post('/vendors/{user}/suspend', [AdminVendorController::class, 'suspend'])->name('admin.vendors.suspend');
        Route::post('/vendors/{user}/activate', [AdminVendorController::class, 'activate'])->name('admin.vendors.activate');
       Route::post('/vendors/{user}/plan', [AdminVendorController::class, 'updatePlan'])->name('admin.vendors.plan');
        Route::get('/categories', [AdminCategoryController::class, 'index'])->name('admin.categories.index');
        Route::post('/categories', [AdminCategoryController::class, 'store'])->name('admin.categories.store');
        Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('admin.categories.destroy');
        Route::get('/reviews', [App\Http\Controllers\Admin\AdminReviewController::class, 'index'])->name('admin.reviews.index');
Route::post('/reviews/{review}/approve', [App\Http\Controllers\Admin\AdminReviewController::class, 'approve'])->name('admin.reviews.approve');
Route::delete('/reviews/{review}', [App\Http\Controllers\Admin\AdminReviewController::class, 'destroy'])->name('admin.reviews.destroy');
    });
});

require __DIR__.'/auth.php';