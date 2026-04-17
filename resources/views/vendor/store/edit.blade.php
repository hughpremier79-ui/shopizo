<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Modifier ma boutique</title>
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
.btn-red { background: #ef4444; color: white; }
.btn-gray { background: #94a3b8; color: white; }
.card { background: white; border-radius: 12px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); margin-bottom: 20px; }
.card-title { font-size: 16px; font-weight: 700; margin-bottom: 20px; border-bottom: 2px solid #f1f5f9; padding-bottom: 10px; }
.form-group { margin-bottom: 20px; }
.form-label { display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px; color: #374151; }
.form-control { width: 100%; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px; color: #1e293b; }
.form-control:focus { outline: none; border-color: #25D366; box-shadow: 0 0 0 3px rgba(37,211,102,0.1); }
.grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
.social-icon { width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
.input-with-icon { display: flex; align-items: center; gap: 10px; }
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
        <h1 class="page-title">Modifier ma boutique</h1>
        <a href="/vendor/store" class="btn btn-gray">← Retour</a>
    </div>

    <div class="card">
        <div class="card-title">Informations générales</div>
        <form method="POST" action="/vendor/store" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label class="form-label">Nom de la boutique</label>
                <input type="text" name="name" value="{{ $store->name }}" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Numéro WhatsApp</label>
                <input type="text" name="whatsapp_number" value="{{ $store->whatsapp_number }}" class="form-control" required>
            </div>
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Ville</label>
                    <input type="text" name="city" value="{{ $store->city }}" class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label">Adresse / Quartier</label>
                    <input type="text" name="address" value="{{ $store->address }}" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" rows="4" class="form-control">{{ $store->description }}</textarea>
            </div>

            <div class="card-title" style="margin-top:20px">Réseaux sociaux (facultatif)</div>

            <div class="form-group">
                <label class="form-label">Facebook</label>
                <div class="input-with-icon">
                    <div class="social-icon" style="background:#1877f2">📘</div>
                    <input type="text" name="facebook" value="{{ $store->facebook }}" class="form-control" placeholder="https://facebook.com/votre-page">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Instagram</label>
                <div class="input-with-icon">
                    <div class="social-icon" style="background:#e1306c">📸</div>
                    <input type="text" name="instagram" value="{{ $store->instagram }}" class="form-control" placeholder="https://instagram.com/votre-compte">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">TikTok</label>
                <div class="input-with-icon">
                    <div class="social-icon" style="background:#010101">🎵</div>
                    <input type="text" name="tiktok" value="{{ $store->tiktok }}" class="form-control" placeholder="https://tiktok.com/@votre-compte">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Logo de la boutique</label>
                @if($store->logo)
                <img src="{{ asset('storage/'.$store->logo) }}" style="width:80px;height:80px;object-fit:cover;border-radius:50%;margin-bottom:10px;display:block">
                @endif
                <input type="file" name="logo" accept="image/*" class="form-control">
            </div>

            <button type="submit" class="btn btn-green" style="width:100%;padding:14px;font-size:16px">Mettre à jour</button>
        </form>
    </div>
</div>

</body>
</html>