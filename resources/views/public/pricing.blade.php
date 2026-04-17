@extends('layouts.public')

@section('title', 'Tarifs — Shopizo')

@section('content')

<div style="background:linear-gradient(135deg,#1e293b,#0f172a);color:white;padding:60px 30px;text-align:center">
<h1 style="font-size:40px;font-weight:800;margin-bottom:15px">Choisissez votre plan</h1>
<p style="color:#94a3b8;font-size:18px">Commencez gratuitement, évoluez selon vos besoins</p>
</div>

<div style="max-width:1000px;margin:60px auto;padding:0 30px">
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:25px">

<div style="background:white;border-radius:16px;padding:30px;box-shadow:0 2px 15px rgba(0,0,0,0.08);text-align:center">
<h3 style="font-size:18px;font-weight:700;margin-bottom:10px">Gratuit</h3>
<div style="font-size:40px;font-weight:800;color:#1e293b;margin-bottom:5px">0 FCFA</div>
<p style="color:#94a3b8;font-size:14px;margin-bottom:25px">Pour commencer</p>
<div style="border-top:1px solid #f1f5f9;padding-top:20px;text-align:left">
<p style="font-size:14px;padding:8px 0;border-bottom:1px solid #f8fafc">✅ 1 boutique</p>
<p style="font-size:14px;padding:8px 0;border-bottom:1px solid #f8fafc">✅ 5 produits maximum</p>
<p style="font-size:14px;padding:8px 0;border-bottom:1px solid #f8fafc">✅ Commandes WhatsApp</p>
<p style="font-size:14px;padding:8px 0;border-bottom:1px solid #f8fafc;color:#94a3b8">❌ Badge vérifié</p>
<p style="font-size:14px;padding:8px 0;color:#94a3b8">❌ Support prioritaire</p>
</div>
<a href="/register" style="display:block;background:#f1f5f9;color:#1e293b;padding:12px;border-radius:8px;text-decoration:none;font-weight:700;margin-top:25px">Commencer gratuitement</a>
</div>

<div style="background:white;border-radius:16px;padding:30px;box-shadow:0 8px 30px rgba(37,211,102,0.2);text-align:center;border:2px solid #25D366;position:relative">
<div style="position:absolute;top:-12px;left:50%;transform:translateX(-50%);background:#25D366;color:white;padding:4px 16px;border-radius:20px;font-size:12px;font-weight:700">POPULAIRE</div>
<h3 style="font-size:18px;font-weight:700;margin-bottom:10px">Standard</h3>
<div style="font-size:40px;font-weight:800;color:#25D366;margin-bottom:5px">3 000 FCFA</div>
<p style="color:#94a3b8;font-size:14px;margin-bottom:25px">Par mois</p>
<div style="border-top:1px solid #f1f5f9;padding-top:20px;text-align:left">
<p style="font-size:14px;padding:8px 0;border-bottom:1px solid #f8fafc">✅ 1 boutique</p>
<p style="font-size:14px;padding:8px 0;border-bottom:1px solid #f8fafc">✅ Produits illimités</p>
<p style="font-size:14px;padding:8px 0;border-bottom:1px solid #f8fafc">✅ Commandes WhatsApp</p>
<p style="font-size:14px;padding:8px 0;border-bottom:1px solid #f8fafc">✅ Badge vérifié</p>
<p style="font-size:14px;padding:8px 0">✅ Support prioritaire</p>
</div>
<a href="/register" style="display:block;background:#25D366;color:white;padding:12px;border-radius:8px;text-decoration:none;font-weight:700;margin-top:25px">Choisir Standard</a>
</div>

<div style="background:white;border-radius:16px;padding:30px;box-shadow:0 2px 15px rgba(0,0,0,0.08);text-align:center">
<h3 style="font-size:18px;font-weight:700;margin-bottom:10px">Premium</h3>
<div style="font-size:40px;font-weight:800;color:#8b5cf6;margin-bottom:5px">7 000 FCFA</div>
<p style="color:#94a3b8;font-size:14px;margin-bottom:25px">Par mois</p>
<div style="border-top:1px solid #f1f5f9;padding-top:20px;text-align:left">
<p style="font-size:14px;padding:8px 0;border-bottom:1px solid #f8fafc">✅ 1 boutique</p>
<p style="font-size:14px;padding:8px 0;border-bottom:1px solid #f8fafc">✅ Produits illimités</p>
<p style="font-size:14px;padding:8px 0;border-bottom:1px solid #f8fafc">✅ Commandes WhatsApp</p>
<p style="font-size:14px;padding:8px 0;border-bottom:1px solid #f8fafc">✅ Badge vérifié Premium</p>
<p style="font-size:14px;padding:8px 0">✅ Support VIP 24h/24</p>
</div>
<a href="/register" style="display:block;background:#8b5cf6;color:white;padding:12px;border-radius:8px;text-decoration:none;font-weight:700;margin-top:25px">Choisir Premium</a>
</div>

</div>

<div style="text-align:center;margin-top:40px;color:#64748b;font-size:14px">
<p style="margin-bottom:20px">Paiement par Mobile Money (MTN, Airtel). Contactez-nous sur WhatsApp pour souscrire.</p>
<a href="https://wa.me/242064244945?text=Bonjour, je veux souscrire à un plan Shopizo." target="_blank" style="display:inline-block;background:#25D366;color:white;padding:15px 30px;border-radius:10px;text-decoration:none;font-weight:700;font-size:16px">
 Nous contacter sur WhatsApp
</a></div>

</div>

@endsection