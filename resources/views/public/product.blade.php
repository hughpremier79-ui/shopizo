@extends('layouts.public')

@section('title', $product->name)

@section('content')

<div style="background:#f8fafc;padding:15px 30px;border-bottom:1px solid #e2e8f0">
<div style="max-width:1100px;margin:0 auto;font-size:13px;color:#64748b">
<a href="/" style="color:#64748b;text-decoration:none">Accueil</a>
<span style="margin:0 8px">›</span>
<a href="/boutique/{{ $product->store->slug }}" style="color:#64748b;text-decoration:none">{{ $product->store->name }}</a>
<span style="margin:0 8px">›</span>
<span style="color:#1e293b">{{ $product->name }}</span>
</div>
</div>

<div style="max-width:1100px;margin:0 auto;padding:40px 30px">
<div style="display:grid;grid-template-columns:1fr 1fr;gap:50px;align-items:start">

<div>
@if($product->image)
<img src="{{ asset('storage/'.$product->image) }}" style="width:100%;height:450px;object-fit:cover;border-radius:16px;box-shadow:0 10px 40px rgba(0,0,0,0.12)">
@else
<div style="width:100%;height:450px;background:linear-gradient(135deg,#f1f5f9,#e2e8f0);border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:80px">📦</div>
@endif

<div style="display:flex;gap:10px;margin-top:15px">
<a href="/boutique/{{ $product->store->slug }}" style="flex:1;background:#f1f5f9;color:#1e293b;padding:12px;border-radius:10px;text-decoration:none;text-align:center;font-size:13px;font-weight:600">
🏪 Voir la boutique
</a>
<a href="https://wa.me/{{ $product->store->whatsapp_number }}" target="_blank" style="flex:1;background:#25D366;color:white;padding:12px;border-radius:10px;text-decoration:none;text-align:center;font-size:13px;font-weight:600">
💬 Contacter
</a>
</div>
</div>

<div>
<div style="display:flex;align-items:center;gap:10px;margin-bottom:15px">
@if($product->store->logo)
<img src="{{ asset('storage/'.$product->store->logo) }}" style="width:40px;height:40px;border-radius:50%;object-fit:cover">
@endif
<div>
<a href="/boutique/{{ $product->store->slug }}" style="color:#25D366;font-size:14px;font-weight:700;text-decoration:none">{{ $product->store->name }}</a>
<p style="color:#94a3b8;font-size:12px">{{ $product->store->city }}</p>
</div>
</div>

<h1 style="font-size:30px;font-weight:800;color:#1e293b;margin-bottom:15px">{{ $product->name }}</h1>

<div style="display:flex;align-items:center;gap:15px;margin-bottom:20px">
<span style="font-size:36px;font-weight:800;color:#25D366">{{ number_format($product->price, 0, ',', '.') }} FCFA</span>
@if($product->stock > 0)
<span style="background:#dcfce7;color:#16a34a;padding:6px 14px;border-radius:20px;font-size:13px;font-weight:600">En stock ({{ $product->stock }})</span>
@else
<span style="background:#fee2e2;color:#dc2626;padding:6px 14px;border-radius:20px;font-size:13px;font-weight:600">Rupture de stock</span>
@endif
</div>

<p style="color:#64748b;line-height:1.8;font-size:15px;margin-bottom:25px">{{ $product->description }}</p>

<div style="background:#f8fafc;border-radius:16px;padding:25px;border:1px solid #e2e8f0">
<h3 style="font-size:18px;font-weight:700;margin-bottom:20px;color:#1e293b">Commander ce produit</h3>
<form method="POST" action="/order">
@csrf
<input type="hidden" name="product_id" value="{{ $product->id }}">
<div style="margin-bottom:15px">
<label style="display:block;font-size:13px;font-weight:600;margin-bottom:6px;color:#374151">Nom complet *</label>
<input type="text" name="client_name" style="width:100%;padding:10px 14px;border:1px solid #e2e8f0;border-radius:8px;font-size:14px" required>
</div>
<div style="margin-bottom:15px">
<label style="display:block;font-size:13px;font-weight:600;margin-bottom:6px;color:#374151">Téléphone *</label>
<input type="text" name="client_phone" style="width:100%;padding:10px 14px;border:1px solid #e2e8f0;border-radius:8px;font-size:14px" required>
</div>
<div style="margin-bottom:15px">
<label style="display:block;font-size:13px;font-weight:600;margin-bottom:6px;color:#374151">Quartier / Adresse *</label>
<input type="text" name="client_area" style="width:100%;padding:10px 14px;border:1px solid #e2e8f0;border-radius:8px;font-size:14px" required>
</div>
<div style="margin-bottom:15px">
<label style="display:block;font-size:13px;font-weight:600;margin-bottom:6px;color:#374151">Quantité *</label>
<div style="display:flex;align-items:center;gap:10px">
<button type="button" onclick="changeQty(-1)" style="width:36px;height:36px;border:1px solid #e2e8f0;border-radius:8px;background:white;font-size:18px;cursor:pointer">-</button>
<input type="number" name="quantity" id="qty" value="1" min="1" max="{{ $product->stock }}" style="width:60px;text-align:center;padding:8px;border:1px solid #e2e8f0;border-radius:8px;font-size:14px" required>
<button type="button" onclick="changeQty(1)" style="width:36px;height:36px;border:1px solid #e2e8f0;border-radius:8px;background:white;font-size:18px;cursor:pointer">+</button>
<span style="color:#64748b;font-size:13px">Total : <strong id="total" style="color:#25D366">{{ number_format($product->price, 0, ',', '.') }} FCFA</strong></span>
</div>
</div>
<div style="margin-bottom:20px">
<label style="display:block;font-size:13px;font-weight:600;margin-bottom:6px;color:#374151">Commentaire (facultatif)</label>
<textarea name="note" rows="3" style="width:100%;padding:10px 14px;border:1px solid #e2e8f0;border-radius:8px;font-size:14px"></textarea>
</div>
<button type="submit" style="width:100%;background:#25D366;color:white;padding:16px;border:none;border-radius:10px;font-size:16px;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:10px">
💬 Commander via WhatsApp
</button>
</form>
</div>
</div>

</div>
</div>

<a href="https://wa.me/{{ $product->store->whatsapp_number }}" target="_blank" style="position:fixed;bottom:30px;right:30px;background:#25D366;color:white;width:60px;height:60px;border-radius:50%;display:flex;align-items:center;justify-content:center;text-decoration:none;box-shadow:0 4px 20px rgba(37,211,102,0.5);z-index:999">
<svg viewBox="0 0 24 24" width="32" height="32" fill="white"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
</a>

<script>
var price = {{ $product->price }};
function changeQty(delta) {
    var qty = document.getElementById('qty');
    var newVal = parseInt(qty.value) + delta;
    if (newVal < 1) newVal = 1;
    if (newVal > {{ $product->stock }}) newVal = {{ $product->stock }};
    qty.value = newVal;
    updateTotal();
}
function updateTotal() {
    var qty = parseInt(document.getElementById('qty').value);
    var total = qty * price;
    document.getElementById('total').textContent = total.toLocaleString('fr-FR') + ' FCFA';
}
document.getElementById('qty').addEventListener('input', updateTotal);
</script>

@endsection