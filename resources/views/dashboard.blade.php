<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tableau de bord</title>
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: 'Segoe UI', sans-serif; background: #f8fafc; color: #1e293b; display: flex; min-height: 100vh; }
.sidebar { width: 250px; background: #1e293b; color: white; padding: 20px; position: fixed; height: 100vh; overflow-y: auto; }
.sidebar-brand { font-size: 22px; font-weight: 800; color: #25D366; margin-bottom: 30px; display: block; text-decoration: none; }
.sidebar-brand span { color: white; }
.sidebar-menu a { display: flex; align-items: center; gap: 10px; color: #94a3b8; text-decoration: none; padding: 12px 15px; border-radius: 8px; margin-bottom: 5px; font-size: 14px; }
.sidebar-menu a:hover, .sidebar-menu a.active { background: rgba(37,211,102,0.15); color: #25D366; }
.sidebar-user { border-top: 1px solid #334155; padding-top: 20px; margin-top: 20px; }
.sidebar-user p { color: #94a3b8; font-size: 13px; margin-bottom: 10px; }
.sidebar-user strong { color: white; font-size: 15px; display: block; margin-bottom: 5px; }
.main { margin-left: 250px; padding: 30px; flex: 1; }
.page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
.page-title { font-size: 24px; font-weight: 700; }
.stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px; }
.stat-card { background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); }
.stat-card .label { font-size: 13px; color: #64748b; margin-bottom: 8px; }
.stat-card .value { font-size: 32px; font-weight: 800; }
.stat-card.blue .value { color: #3b82f6; }
.stat-card.orange .value { color: #f59e0b; }
.stat-card.green .value { color: #25D366; }
.stat-card.purple .value { color: #8b5cf6; }
.quick-links { display: flex; gap: 15px; margin-bottom: 30px; flex-wrap: wrap; }
.quick-link { background: white; border-radius: 10px; padding: 15px 20px; text-decoration: none; color: #1e293b; font-size: 14px; font-weight: 600; box-shadow: 0 2px 10px rgba(0,0,0,0.06); display: flex; align-items: center; gap: 8px; }
.quick-link:hover { transform: translateY(-2px); box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
.card { background: white; border-radius: 12px; padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); }
.card-title { font-size: 16px; font-weight: 700; margin-bottom: 20px; }
table { width: 100%; border-collapse: collapse; }
th { text-align: left; padding: 10px 15px; font-size: 13px; color: #64748b; border-bottom: 1px solid #f1f5f9; }
td { padding: 12px 15px; font-size: 14px; border-bottom: 1px solid #f8fafc; }
.badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; }
.badge-pending { background: #fef3c7; color: #d97706; }
.badge-confirmed { background: #dbeafe; color: #2563eb; }
.badge-delivered { background: #dcfce7; color: #16a34a; }
.badge-cancelled { background: #fee2e2; color: #dc2626; }
.btn { display: inline-block; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 600; border: none; cursor: pointer; }
.btn-sm { padding: 5px 12px; font-size: 12px; }
.btn-blue { background: #3b82f6; color: white; }
.btn-red { background: #ef4444; color: white; }
.alert-danger { background: #fee2e2; border-left: 4px solid #ef4444; padding: 15px 20px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 15px; }
</style>
</head>
<body>

<div class="sidebar">
    <a href="/dashboard" class="sidebar-brand">Shopi<span>zo</span></a>
    <div class="sidebar-menu">
        <a href="/dashboard" class="active">📊 Tableau de bord</a>
        <a href="/vendor/store">🏪 Ma Boutique</a>
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
        <h1 class="page-title">Tableau de bord</h1>
    </div>

    @if($pendingOrders > 0)
    <div class="alert-danger">
        <span style="font-size:24px">🔔</span>
        <div>
            <strong>{{ $pendingOrders }} commande(s) en attente !</strong>
            <p style="font-size:13px;margin-top:3px">Traitez vos commandes rapidement.</p>
        </div>
        <a href="/vendor/orders" class="btn btn-red" style="margin-left:auto">Voir les commandes</a>
    </div>
    @endif

    <div class="stats-grid">
        <div class="stat-card blue">
            <div class="label">Total Produits</div>
            <div class="value">{{ $totalProducts }}</div>
        </div>
        <div class="stat-card orange">
            <div class="label">En attente</div>
            <div class="value">{{ $pendingOrders }}</div>
        </div>
        <div class="stat-card green">
            <div class="label">Total Commandes</div>
            <div class="value">{{ $totalOrders }}</div>
        </div>
        <div class="stat-card purple">
            <div class="label">Livrées</div>
            <div class="value">{{ $deliveredOrders }}</div>
        </div>
    </div>

    <div class="card">
        <div class="card-title">Dernières commandes</div>
        <table>
            <thead>
                <tr>
                    <th>Ref</th>
                    <th>Produit</th>
                    <th>Client</th>
                    <th>Total</th>
                    <th>Statut</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($latestOrders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->product->name }}</td>
                    <td>{{ $order->client_name }}</td>
                    <td>{{ number_format($order->total_price, 0, ',', '.') }} FCFA</td>
                    <td>
                        @if($order->status == 'pending')
                        <span class="badge badge-pending">En attente</span>
                        @elseif($order->status == 'confirmed')
                        <span class="badge badge-confirmed">Confirmée</span>
                        @elseif($order->status == 'delivered')
                        <span class="badge badge-delivered">Livrée</span>
                        @elseif($order->status == 'cancelled')
                        <span class="badge badge-cancelled">Annulée</span>
                        @else
                        <span class="badge">{{ $order->status }}</span>
                        @endif
                    </td>
                    <td><a href="/vendor/orders/{{ $order->id }}" class="btn btn-blue btn-sm">Voir</a></td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center;color:#64748b;padding:30px">Aucune commande</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</body>
</html>