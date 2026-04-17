<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Commande #{{ $order->id }}</title>
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
.btn-blue { background: #3b82f6; color: white; }
.btn-red { background: #ef4444; color: white; }
.btn-gray { background: #94a3b8; color: white; }
.grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
.card { background: white; border-radius: 12px; padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); margin-bottom: 20px; }
.card-title { font-size: 16px; font-weight: 700; margin-bottom: 20px; color: #1e293b; border-bottom: 2px solid #f1f5f9; padding-bottom: 10px; }
.info-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f8fafc; font-size: 14px; }
.info-row:last-child { border-bottom: none; }
.info-label { color: #64748b; }
.info-value { font-weight: 600; }
.badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
.badge-pending { background: #fef3c7; color: #d97706; }
.badge-confirmed { background: #dbeafe; color: #2563eb; }
.badge-processing { background: #f3e8ff; color: #7c3aed; }
.badge-delivered { background: #dcfce7; color: #16a34a; }
.badge-cancelled { background: #fee2e2; color: #dc2626; }
.alert-success { background: #dcfce7; border-left: 4px solid #25D366; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; color: #16a34a; font-size: 14px; }
select { padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px; margin-right: 10px; }
.history-item { display: flex; align-items: center; gap: 10px; padding: 10px 0; border-bottom: 1px solid #f8fafc; font-size: 13px; }
.history-item:last-child { border-bottom: none; }
</style>
</head>
<body>

<div class="sidebar">
    <a href="/dashboard" class="sidebar-brand">Shopi<span>zo</span></a>
    <div class="sidebar-menu">
        <a href="/dashboard">📊 Tableau de bord</a>
        <a href="/vendor/store">🏪 Ma Boutique</a>
        <a href="/vendor/products">📦 Mes Produits</a>
        <a href="/vendor/products/create">➕ Ajouter Produit</a>
        <a href="/vendor/orders" class="active">📋 Mes Commandes</a>
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
        <div>
            <h1 class="page-title">Commande #{{ $order->id }}</h1>
            <p style="color:#64748b;font-size:14px;margin-top:5px">{{ $order->created_at->format('d/m/Y à H:i') }}</p>
        </div>
        <a href="/vendor/orders" class="btn btn-gray">← Retour</a>
    </div>

    @if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="grid-2">
        <div class="card">
            <div class="card-title">Informations client</div>
            <div class="info-row">
                <span class="info-label">Nom</span>
                <span class="info-value">{{ $order->client_name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Telephone</span>
                <span class="info-value">{{ $order->client_phone }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Quartier</span>
                <span class="info-value">{{ $order->client_area }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Note</span>
                <span class="info-value">{{ $order->note ?? 'Aucune' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Source</span>
                <span class="badge badge-confirmed">{{ $order->source }}</span>
            </div>
        </div>

        <div class="card">
            <div class="card-title">Informations produit</div>
            <div class="info-row">
                <span class="info-label">Produit</span>
                <span class="info-value">{{ $order->product->name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Prix unitaire</span>
                <span class="info-value">{{ number_format($order->unit_price, 0, ',', '.') }} FCFA</span>
            </div>
            <div class="info-row">
                <span class="info-label">Quantite</span>
                <span class="info-value">{{ $order->quantity }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Total</span>
                <span class="info-value" style="color:#25D366;font-size:18px">{{ number_format($order->total_price, 0, ',', '.') }} FCFA</span>
            </div>
            <div class="info-row">
                <span class="info-label">Statut</span>
                <span>
                    @if($order->status == 'pending')
                    <span class="badge badge-pending">En attente</span>
                    @elseif($order->status == 'confirmed')
                    <span class="badge badge-confirmed">Confirmée</span>
                    @elseif($order->status == 'processing')
                    <span class="badge badge-processing">En cours</span>
                    @elseif($order->status == 'delivered')
                    <span class="badge badge-delivered">Livrée</span>
                    @elseif($order->status == 'cancelled')
                    <span class="badge badge-cancelled">Annulée</span>
                    @endif
                </span>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-title">Changer le statut</div>
        <form method="POST" action="/vendor/orders/{{ $order->id }}/status" style="display:flex;align-items:center;gap:10px">
            @csrf
            <select name="status">
                <option value="pending" @selected($order->status == 'pending')>En attente</option>
                <option value="confirmed" @selected($order->status == 'confirmed')>Confirmée</option>
                <option value="processing" @selected($order->status == 'processing')>En cours</option>
                <option value="delivered" @selected($order->status == 'delivered')>Livrée</option>
                <option value="cancelled" @selected($order->status == 'cancelled')>Annulée</option>
            </select>
            <button type="submit" class="btn btn-blue">Mettre à jour</button>
        </form>
    </div>

    <div class="card">
        <div class="card-title">Historique des statuts</div>
        @forelse($order->statusHistories as $history)
        <div class="history-item">
            <span style="color:#64748b">{{ $history->created_at->format('d/m/Y H:i') }}</span>
            <span style="color:#94a3b8">→</span>
            <span>{{ $history->old_status }}</span>
            <span style="color:#25D366">→</span>
            <span style="font-weight:600">{{ $history->new_status }}</span>
        </div>
        @empty
        <p style="color:#64748b;font-size:14px">Aucun historique</p>
        @endforelse
    </div>
</div>

</body>
</html>