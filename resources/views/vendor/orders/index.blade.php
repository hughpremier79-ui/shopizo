<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mes Commandes</title>
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
.card { background: white; border-radius: 12px; padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); }
table { width: 100%; border-collapse: collapse; }
th { text-align: left; padding: 12px 15px; font-size: 13px; color: #64748b; border-bottom: 2px solid #f1f5f9; }
td { padding: 12px 15px; font-size: 14px; border-bottom: 1px solid #f8fafc; vertical-align: middle; }
.badge { display: inline-block; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; }
.badge-pending { background: #fef3c7; color: #d97706; }
.badge-confirmed { background: #dbeafe; color: #2563eb; }
.badge-processing { background: #f3e8ff; color: #7c3aed; }
.badge-delivered { background: #dcfce7; color: #16a34a; }
.badge-cancelled { background: #fee2e2; color: #dc2626; }
.alert-success { background: #dcfce7; border-left: 4px solid #25D366; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; color: #16a34a; font-size: 14px; }
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
        <h1 class="page-title">Mes Commandes</h1>
    </div>

    @if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Ref</th>
                    <th>Produit</th>
                    <th>Client</th>
                    <th>Telephone</th>
                    <th>Total</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td><strong>#{{ $order->id }}</strong></td>
                    <td>{{ $order->product->name }}</td>
                    <td>{{ $order->client_name }}</td>
                    <td>{{ $order->client_phone }}</td>
                    <td style="color:#25D366;font-weight:700">{{ number_format($order->total_price, 0, ',', '.') }} FCFA</td>
                    <td>
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
                    </td>
                    <td style="color:#64748b;font-size:13px">{{ $order->created_at->format('d/m/Y') }}</td>
                    <td><a href="/vendor/orders/{{ $order->id }}" class="btn btn-blue btn-sm">Voir</a></td>
                </tr>
                @empty
                <tr><td colspan="8" style="text-align:center;color:#64748b;padding:40px">Aucune commande pour le moment</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
