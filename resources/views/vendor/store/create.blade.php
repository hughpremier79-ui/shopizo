<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Créer ma boutique</title>
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
.card { background: white; border-radius: 12px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); }
.form-group { margin-bottom: 20px; }
.form-label { display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px; color: #374151; }
.form-control { width: 100%; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px; color: #1e293b; }
.form-control:focus { outline: none; border-color: #25D366; box-shadow: 0 0 0 3px rgba(37,211,102,0.1); }
.grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
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
        <h1 class="page-title">Créer ma boutique</h1>
        <a href="/dashboard" class="btn btn-gray">← Retour</a>
    </div>

    <div class="card">
        <form method="POST" action="/vendor/store">
            @csrf
            <div class="form-group">
                <label class="form-label">Nom de la boutique</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Numéro WhatsApp</label>
                <input type="text" name="whatsapp_number" class="form-control" placeholder="Ex: 242XXXXXXXX" required>
            </div>
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Ville</label>
                    <input type="text" name="city" class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label">Adresse / Quartier</label>
                    <input type="text" name="address" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" rows="4" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-green" style="width:100%;padding:14px;font-size:16px">Créer la boutique</button>
        </form>
    </div>
</div>

</body>
</html>