@extends('layouts.public')

@section('title', $store->name)

@section('content')

<div style="background:linear-gradient(135deg,#1e293b,#0f172a);color:white;padding:50px 30px">
<div style="max-width:1100px;margin:0 auto;display:flex;align-items:center;gap:30px;flex-wrap:wrap">
@if($store->logo)
<img src="{{ asset('storage/'.$store->logo) }}" style="width:100px;height:100px;object-fit:cover;border-radius:50%;flex-shrink:0;border:3px solid #25D366">
@else
<div style="width:100px;height:100px;background:#25D366;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:40px;flex-shrink:0">🏪</div>
@endif
<h1 style="font-size:32px;font-weight:800;margin-bottom:8px">{{ $store->name }}</h1>
<p style="color:#94a3b8;margin-bottom:8px">{{ $store->description }}</p>
<p style="color:#94a3b8;font-size:14px;margin-bottom:15px">📍 {{ $store->city }} — {{ $store->address }}</p>
<div style="display:flex;gap:10px;flex-wrap:wrap">
<a href="https://wa.me/{{ $store->whatsapp_number }}" target="_blank" style="background:#25D366;color:white;padding:10px 18px;border-radius:8px;text-decoration:none;font-weight:700;font-size:14px;display:flex;align-items:center;gap:6px">
💬 WhatsApp
</a>
@if($store->facebook)
<a href="{{ $store->facebook }}" target="_blank" style="background:#1877f2;color:white;padding:10px 18px;border-radius:8px;text-decoration:none;font-weight:700;font-size:14px;display:flex;align-items:center;gap:6px">
📘 Facebook
</a>
@endif
@if($store->instagram)
<a href="{{ $store->instagram }}" target="_blank" style="background:#e1306c;color:white;padding:10px 18px;border-radius:8px;text-decoration:none;font-weight:700;font-size:14px;display:flex;align-items:center;gap:6px">
📸 Instagram
</a>
@endif
@if($store->tiktok)
<a href="{{ $store->tiktok }}" target="_blank" style="background:#010101;color:white;padding:10px 18px;border-radius:8px;text-decoration:none;font-weight:700;font-size:14px;display:flex;align-items:center;gap:6px">
🎵 TikTok
</a>
@endif
</div>
</div>
</div>
</div>

<div style="background:#f1f5f9;padding:20px 30px;border-bottom:1px solid #e2e8f0">
<div style="max-width:1100px;margin:0 auto;display:flex;gap:30px;align-items:center;flex-wrap:wrap">
<div style="display:flex;gap:30px">
<div style="text-align:center">
<div style="font-size:22px;font-weight:800;color:#1e293b">{{ $products->count() }}</div>
<div style="font-size:12px;color:#64748b">Produits</div>
</div>
<div style="text-align:center">
<div style="font-size:22px;font-weight:800;color:#25D366">✓</div>
<div style="font-size:12px;color:#64748b">Boutique vérifiée</div>
</div>
<div style="text-align:center">
<div style="font-size:22px;font-weight:800;color:#1e293b">{{ $store->city }}</div>
<div style="font-size:12px;color:#64748b">Localisation</div>
</div>
</div>
<div style="margin-left:auto">
<input type="text" id="search-input" placeholder="Rechercher un produit..." onkeyup="searchProducts()" style="padding:10px 16px;border:1px solid #e2e8f0;border-radius:8px;font-size:14px;width:280px">
</div>
</div>
</div>

<div class="container">

@if($products->isEmpty())
<div style="text-align:center;padding:80px 20px">
<div style="font-size:60px;margin-bottom:20px">📦</div>
<h3 style="font-size:20px;color:#1e293b;margin-bottom:10px">Aucun produit disponible</h3>
<p style="color:#64748b">Cette boutique n'a pas encore ajouté de produits.</p>
</div>
@else
<h2 style="font-size:20px;font-weight:700;margin-bottom:25px">Tous les produits ({{ $products->count() }})</h2>
<div id="products-grid" style="display:grid;grid-template-columns:repeat(3,1fr);gap:25px">
@foreach($products as $product)
<div class="product-card" data-name="{{ strtolower($product->name) }}" style="background:white;border-radius:16px;overflow:hidden;box-shadow:0 2px 15px rgba(0,0,0,0.08);transition:transform 0.2s" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
@if($product->image)
<img src="{{ asset('storage/'.$product->image) }}" style="width:100%;height:220px;object-fit:cover">
@else
<div style="width:100%;height:220px;background:linear-gradient(135deg,#f1f5f9,#e2e8f0);display:flex;align-items:center;justify-content:center;font-size:60px">📦</div>
@endif
<div style="padding:18px">
<h3 style="font-size:16px;font-weight:700;margin-bottom:6px;color:#1e293b">{{ $product->name }}</h3>
<p style="color:#64748b;font-size:13px;margin-bottom:12px;line-height:1.5">{{ Str::limit($product->description, 70) }}</p>
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:15px">
<span style="font-size:20px;font-weight:800;color:#25D366">{{ number_format($product->price, 0, ',', '.') }} FCFA</span>
<span style="font-size:12px;color:#94a3b8">Stock: {{ $product->stock }}</span>
</div>
<a href="/p/{{ $product->slug }}" style="display:block;background:#25D366;color:white;text-align:center;padding:12px;border-radius:8px;text-decoration:none;font-weight:700;font-size:14px">
Commander
</a>
</div>
</div>
@endforeach
</div>

<div id="no-results" style="display:none;text-align:center;padding:60px">
<div style="font-size:50px;margin-bottom:15px">🔍</div>
<p style="color:#64748b;font-size:16px">Aucun produit trouvé</p>
</div>
@endif

</div>

://wa.m<a href="httpse/{{ $store->whatsapp_number }}" target="_blank" style="position:fixed;bottom:30px;right:30px;background:#25D366;color:white;width:60px;height:60px;border-radius:50%;display:flex;align-items:center;justify-content:center;text-decoration:none;box-shadow:0 4px 20px rgba(37,211,102,0.5);z-index:999">
<svg viewBox="0 0 24 24" width="32" height="32" fill="white"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
</a>

<script>
function searchProducts() {
    var input = document.getElementById('search-input').value.toLowerCase();
    var cards = document.querySelectorAll('.product-card');
    var found = 0;
    cards.forEach(function(card) {
        var name = card.getAttribute('data-name');
        if (name.includes(input)) {
            card.style.display = 'block';
            found++;
        } else {
            card.style.display = 'none';
        }
    });
    document.getElementById('no-results').style.display = found === 0 ? 'block' : 'none';
}
</script>

@endsection