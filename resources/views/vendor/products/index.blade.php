<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mes Produits</title>
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: 'Segoe UI', sans-serif; background: #f8fafc; color: #1e293b; display: flex; min-height: 100vh; }
.sidebar { width: 250px; background: #1e293b; color: white; padding: 20px; position: fixed; height: 100vh; overflow-y: auto; }
.sidebar-brand { font-size: 22px; font-weight: 800; color: #25D366; margin-bottom: 30px; display: block; text-decoration: none; }
.sidebar-brand span { color: white; }
.sidebar-menu a { display: flex; align-items: center; gap: 10px; color: #94a3b8; text-decoration: none; padding: 12px 15px; border-radius: 8px; margin-bottom: 5px; font-size: 14px; }
.sidebar-menu a:hover, .sidebar-menu a.active { background: rgba(37,211,102,0.15); color: #25D366; }
.sidebar-user { border-top: 1px solid #334155; padding-top: 20px; margin-top: 20px; }
.sidebar-user strong { color: white; font-size: 15px; display: block; margin-bottom: 5px; }
.sidebar-user p { color: #94a3b8; font-size: 13px; margin-bottom: 10px; }
.main { margin-left: 250px; padding: 30px; flex: 1; }
.page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
.page-title { font-size: 24px; font-weight: 700; }
.btn { display: inline-block; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 600; border: none; cursor: pointer; }
.btn-sm { padding: 6px 12px; font-size: 12px; }
.btn-green { background: #25D366; color: white; }
.btn-blue { background: #3b82f6; color: white; }
.btn-red { background: #ef4444; color: white; }
.btn-orange { background: #f59e0b; color: white; }
.card { background: white; border-radius: 12px; padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); }
table { width: 100%; border-collapse: collapse; }
th { text-align: left; padding: 12px 15px; font-size: 13px; color: #64748b; border-bottom: 2px solid #f1f5f9; }
td { padding: 12px 15px; font-size: 14px; border-bottom: 1px solid #f8fafc; vertical-align: middle; }
.badge { display: inline-block; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; }
.badge-active { background: #dcfce7; color: #16a34a; }
.badge-inactive { background: #fee2e2; color: #dc2626; }
.alert-success { background: #dcfce7; border-left: 4px solid #25D366; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; color: #16a34a; font-size: 14px; }
#copy-msg { background: #dbeafe; border-left: 4px solid #3b82f6; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; color: #2563eb; font-size: 14px; display: none; }
</style>
</head>
<body>

<div class="sidebar">
    <a href="/dashboard" class="sidebar-brand">Shopi<span>zo</span></a>
    <div class="sidebar-menu">
        <a href="/dashboard">📊 Tableau de bord</a>
        <a href="/vendor/store">🏪 Ma Boutique</a>
        <a href="/vendor/products" class="active">📦 Mes Produits</a>
        <a href="/vendor/products/create">➕ Ajouter Produit</a>
        <a href="/vendor/orders">📋 Mes Commandes</a>
    </div>
    <div class="sidebar-user">
        <strong>{{ Auth::user()->name }}</strong>
        <p>{{ Auth::user()->email }}</p>
        <form method="POST" action="/logout">
            @csrf
            <button type="submit" class="btn btn-red" style="width:100%;margin-top:10px">Déconnexion</button>
        </form>
    </div>
</div>

<div class="main">
    <div class="page-header">
        <h1 class="page-title">Mes Produits</h1>
        <a href="/vendor/products/create" class="btn btn-green">+ Ajouter un produit</a>
    </div>

    @if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
    @endif

@if(session('error'))
<div style="background:#fee2e2;border-left:4px solid #ef4444;padding:12px 20px;border-radius:8px;margin-bottom:20px;color:#dc2626;font-size:14px">
{{ session('error') }}
<a href="/tarifs" style="color:#dc2626;font-weight:700;margin-left:10px">Voir les plans →</a>
</div>
@endif

    <div id="copy-msg">Lien copié avec succès !</div>

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Nom</th>
                    <th>Prix</th>
                    <th>Stock</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>
                        @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}" style="width:55px;height:55px;object-fit:cover;border-radius:8px">
                        @else
                        <div style="width:55px;height:55px;background:#f1f5f9;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:24px">📦</div>
                        @endif
                    </td>
                    <td><strong>{{ $product->name }}</strong></td>
                    <td style="color:#25D366;font-weight:700">{{ number_format($product->price, 0, ',', '.') }} FCFA</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        @if($product->status == 'active')
                        <span class="badge badge-active">Actif</span>
                        @else
                        <span class="badge badge-inactive">Inactif</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;gap:6px;flex-wrap:wrap">
                            <a href="/p/{{ $product->slug }}" target="_blank" class="btn btn-blue btn-sm">Voir</a>
                            <button onclick="copyLink('{{ url('/p/'.$product->slug) }}')" class="btn btn-green btn-sm">Copier lien</button>
                            <a href="/vendor/products/{{ $product->id }}/edit" class="btn btn-orange btn-sm">Modifier</a>
                            <form method="POST" action="/vendor/products/{{ $product->id }}" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-red btn-sm">Supprimer</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center;color:#64748b;padding:40px">Aucun produit — <a href="/vendor/products/create" style="color:#25D366">Ajouter votre premier produit</a></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
function copyLink(url) {
    var tempInput = document.createElement('input');
    tempInput.value = url;
    document.body.appendChild(tempInput);
    tempInput.select();
    document.execCommand('copy');
    document.body.removeChild(tempInput);
    var msg = document.getElementById('copy-msg');
    msg.style.display = 'block';
    setTimeout(function() { msg.style.display = 'none'; }, 3000);
}
</script>

</body>
</html>