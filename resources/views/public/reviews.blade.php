@extends('layouts.public')

@section('title', 'Avis clients — Shopizo')

@section('content')

<div style="background:linear-gradient(135deg,#1e293b,#0f172a);color:white;padding:60px 30px;text-align:center">
<h1 style="font-size:40px;font-weight:800;margin-bottom:15px">Avis de nos vendeurs</h1>
<p style="color:#94a3b8;font-size:18px">Ce que disent ceux qui utilisent Shopizo</p>
</div>

<div style="max-width:1000px;margin:60px auto;padding:0 30px">

@if(session('success'))
<div style="background:#dcfce7;border-left:4px solid #25D366;padding:15px 20px;border-radius:8px;margin-bottom:30px;color:#16a34a;font-size:14px">
{{ session('success') }}
</div>
@endif

@if($reviews->isEmpty())
<div style="text-align:center;padding:60px;background:white;border-radius:16px;box-shadow:0 2px 15px rgba(0,0,0,0.08);margin-bottom:40px">
<div style="width:80px;height:80px;background:#f1f5f9;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px">
<svg viewBox="0 0 24 24" width="40" height="40" fill="#94a3b8"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"/></svg>
</div>
<h3 style="font-size:20px;font-weight:700;color:#1e293b;margin-bottom:10px">Partagez votre expérience !</h3>
<p style="color:#64748b;font-size:14px;max-width:400px;margin:0 auto">Les avis de nos vendeurs nous aident à améliorer Shopizo. Partagez votre expérience ci-dessous.</p>
</div>
@else
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:25px;margin-bottom:50px">
@foreach($reviews as $review)
<div style="background:white;border-radius:16px;padding:25px;box-shadow:0 2px 15px rgba(0,0,0,0.08)">
<div style="color:#f59e0b;font-size:20px;margin-bottom:15px">
@for($i = 1; $i <= 5; $i++)
{{ $i <= $review->rating ? '★' : '☆' }}
@endfor
</div>
<p style="color:#374151;font-size:14px;line-height:1.7;margin-bottom:20px">"{{ $review->comment }}"</p>
<div style="display:flex;align-items:center;gap:10px">
<div style="width:40px;height:40px;background:#25D366;border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-weight:700">
{{ strtoupper(substr($review->name, 0, 1)) }}
</div>
<div>
<p style="font-weight:700;font-size:14px">{{ $review->name }}</p>
<p style="color:#94a3b8;font-size:12px">{{ $review->business }} — {{ $review->city }}</p>
</div>
</div>
</div>
@endforeach
</div>
@endif

<div style="background:white;border-radius:16px;padding:35px;box-shadow:0 2px 15px rgba(0,0,0,0.08);margin-bottom:40px">
<h3 style="font-size:22px;font-weight:700;margin-bottom:25px">Donnez votre avis</h3>
<form method="POST" action="/avis">
@csrf
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px">
<div>
<label style="display:block;font-size:13px;font-weight:600;margin-bottom:8px">Votre nom *</label>
<input type="text" name="name" style="width:100%;padding:10px 14px;border:1px solid #e2e8f0;border-radius:8px;font-size:14px" required>
</div>
<div>
<label style="display:block;font-size:13px;font-weight:600;margin-bottom:8px">Votre activité</label>
<input type="text" name="business" placeholder="Ex: Vente de vêtements" style="width:100%;padding:10px 14px;border:1px solid #e2e8f0;border-radius:8px;font-size:14px">
</div>
</div>
<div style="margin-bottom:20px">
<label style="display:block;font-size:13px;font-weight:600;margin-bottom:8px">Ville</label>
<input type="text" name="city" placeholder="Ex: Brazzaville" style="width:100%;padding:10px 14px;border:1px solid #e2e8f0;border-radius:8px;font-size:14px">
</div>
<div style="margin-bottom:20px">
<label style="display:block;font-size:13px;font-weight:600;margin-bottom:8px">Note *</label>
<div style="display:flex;gap:10px">
@for($i = 1; $i <= 5; $i++)
<label style="cursor:pointer;display:flex;align-items:center;gap:5px;font-size:14px">
<input type="radio" name="rating" value="{{ $i }}" {{ $i == 5 ? 'checked' : '' }}>
{{ $i }} ★
</label>
@endfor
</div>
</div>
<div style="margin-bottom:25px">
<label style="display:block;font-size:13px;font-weight:600;margin-bottom:8px">Votre avis *</label>
<textarea name="comment" rows="4" placeholder="Partagez votre expérience avec Shopizo..." style="width:100%;padding:10px 14px;border:1px solid #e2e8f0;border-radius:8px;font-size:14px" required></textarea>
</div>
<button type="submit" style="background:#25D366;color:white;padding:14px 30px;border:none;border-radius:8px;font-size:15px;font-weight:700;cursor:pointer;width:100%">
Envoyer mon avis
</button>
</form>
</div>

</div>

<a href="https://wa.me/242064244945" target="_blank" style="position:fixed;bottom:30px;right:30px;background:#25D366;color:white;width:60px;height:60px;border-radius:50%;display:flex;align-items:center;justify-content:center;text-decoration:none;box-shadow:0 4px 20px rgba(37,211,102,0.5);z-index:999">
<svg viewBox="0 0 24 24" width="32" height="32" fill="white"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
</a>

@endsection