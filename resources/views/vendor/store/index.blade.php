<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ma Boutique</title>
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
.btn-green { background: #25D366; color: white; }
.btn-blue { background: #3b82f6; color: white; }
.btn-red { background: #ef4444; color: white; }
.btn-orange { background: #f59e0b; color: white; }
.card { background: white; border-radius: 12px; padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); margin-bottom: 20px; }
.card-title { font-size: 16px; font-weight: 700; margin-bottom: 20px; color: #1e293b; border-bottom: 2px solid #f1f5f9; padding-bottom: 10px; }
.info-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f8fafc; font-size: 14px; }
.info-row:last-child { border-bottom: none; }
.info-label { color: #64748b; }
.info-value { font-weight: 600; }
.alert-success { background: #dcfce7; border-left: 4px solid #25D366; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; color: #16a34a; font-size: 14px; }
#copy-msg { background: #dbeafe; border-left: 4px solid #3b82f6; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; color: #2563eb; font-size: 14px; display: none; }
</style>
</head>
<body>

<div class="sidebar">
    <a href="/dashboard" class="sidebar-brand">Shopi<span>zo</span></a>
    <div class="sidebar-menu">
        <a href="/dashboard">📊 Tableau de bord</a>
        <a href="/vendor/store" class="active">🏪 Ma Boutique</a>
        <a href="/vendor/products">📦 Mes Produits</a>
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
        <h1 class="page-title">Ma Boutique</h1>
    </div>

    @if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div id="copy-msg">Lien copié avec succès !</div>

    @if($store)
    <div class="card">
        <div class="card-title">Informations de la boutique</div>
        <div class="info-row">
            <span class="info-label">Nom</span>
            <span class="info-value">{{ $store->name }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">WhatsApp</span>
            <span class="info-value">{{ $store->whatsapp_number }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Ville</span>
            <span class="info-value">{{ $store->city }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Adresse</span>
            <span class="info-value">{{ $store->address }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Description</span>
            <span class="info-value">{{ $store->description }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Statut</span>
            <span style="background:#dcfce7;color:#16a34a;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600">{{ $store->status }}</span>
        </div>
        <div style="display:flex;gap:10px;margin-top:20px">
            <a href="/vendor/store/edit" class="btn btn-blue">Modifier</a>
            <button onclick="copyLink('{{ url('/boutique/'.$store->slug) }}')" class="btn btn-green">Copier lien boutique</button>
            <a href="/boutique/{{ $store->slug }}" target="_blank" class="btn btn-orange">Voir ma boutique</a>
        </div>
    </div>
    @else
    <div class="card" style="text-align:center;padding:50px">
        <p style="color:#64748b;font-size:16px;margin-bottom:20px">Vous n'avez pas encore de boutique.</p>
        <a href="/vendor/store/create" class="btn btn-green">Créer ma boutique</a>
    </div>
    @endif
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