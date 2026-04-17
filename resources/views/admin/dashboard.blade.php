<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: 'Segoe UI', sans-serif; background: #f8fafc; color: #1e293b; display: flex; min-height: 100vh; }
.sidebar { width: 250px; background: #0f172a; color: white; padding: 20px; position: fixed; height: 100vh; overflow-y: auto; }
.sidebar-brand { font-size: 22px; font-weight: 800; color: #ef4444; margin-bottom: 10px; display: block; text-decoration: none; }
.sidebar-brand span { color: white; }
.sidebar-badge { background: #ef4444; color: white; font-size: 10px; padding: 2px 8px; border-radius: 10px; margin-bottom: 30px; display: inline-block; }
.sidebar-menu a { display: flex; align-items: center; gap: 10px; color: #94a3b8; text-decoration: none; padding: 12px 15px; border-radius: 8px; margin-bottom: 5px; font-size: 14px; }
.sidebar-menu a:hover, .sidebar-menu a.active { background: rgba(239,68,68,0.15); color: #ef4444; }
.sidebar-user { border-top: 1px solid #1e293b; padding-top: 20px; margin-top: 20px; }
.sidebar-user strong { color: white; font-size: 15px; display: block; margin-bottom: 5px; }
.sidebar-user p { color: #94a3b8; font-size: 13px; margin-bottom: 10px; }
.main { margin-left: 250px; padding: 30px; flex: 1; }
.page-header { margin-bottom: 30px; }
.page-title { font-size: 24px; font-weight: 700; }
.page-subtitle { color: #64748b; font-size: 14px; margin-top: 5px; }
.stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px; }
.stat-card { background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); }
.stat-card .label { font-size: 13px; color: #64748b; margin-bottom: 8px; }
.stat-card .value { font-size: 32px; font-weight: 800; }
.stat-card.blue .value { color: #3b82f6; }
.stat-card.green .value { color: #25D366; }
.stat-card.orange .value { color: #f59e0b; }
.stat-card.purple .value { color: #8b5cf6; }
.card { background: white; border-radius: 12px; padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); margin-bottom: 20px; }
.card-title { font-size: 16px; font-weight: 700; margin-bottom: 20px; color: #1e293b; border-bottom: 2px solid #f1f5f9; padding-bottom: 10px; }
table { width: 100%; border-collapse: collapse; }
th { text-align: left; padding: 12px 15px; font-size: 13px; color: #64748b; border-bottom: 2px solid #f1f5f9; }
td { padding: 12px 15px; font-size: 14px; border-bottom: 1px solid #f8fafc; }
.badge { display: inline-block; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; }
.badge-active { background: #dcfce7; color: #16a34a; }
.badge-suspended { background: #fee2e2; color: #dc2626; }
.btn { display: inline-block; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 600; border: none; cursor: pointer; }
.btn-red { background: #ef4444; color: white; }
.btn-gray { background: #64748b; color: white; }
</style>
</head>
<body>

<div class="sidebar">
    <a href="/admin" class="sidebar-brand">Shopi<span>zo</span></a>
    <span class="sidebar-badge">ADMIN</span>
    <div class="sidebar-menu">
        <a href="/admin" class="active">📊 Dashboard</a>
        <a href="/admin/vendors">👥 Vendeurs</a>
        <a href="/admin/categories">🏷️ Catégories</a>
        <a href="/admin/reviews">⭐ Avis</a>
        <a href="/dashboard">🏪 Espace vendeur</a>
    </div>
    <div class="sidebar-user">
        <strong>{{ Auth::user()->name }}</strong>
        <p>Administrateur</p>
        <form method="POST" action="/logout">
            @csrf
            <button type="submit" class="btn btn-red" style="width:100%;margin-top:10px">Déconnexion</button>
        </form>
    </div>
</div>

<div class="main">
    <div class="page-header">
        <h1 class="page-title">Tableau de bord Admin</h1>
        <p class="page-subtitle">Vue globale de la plateforme</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card blue">
            <div class="label">Total Vendeurs</div>
            <div class="value">{{ $totalVendors }}</div>
        </div>
        <div class="stat-card green">
            <div class="label">Total Produits</div>
            <div class="value">{{ $totalProducts }}</div>
        </div>
        <div class="stat-card orange">
            <div class="label">Total Commandes</div>
            <div class="value">{{ $totalOrders }}</div>
        </div>
        <div class="stat-card purple">
            <div class="label">En attente</div>
            <div class="value">{{ $pendingOrders }}</div>
        </div>
    </div>

    <div class="card">
        <div class="card-title">Derniers vendeurs inscrits</div>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Statut</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($latestVendors as $vendor)
                <tr>
                    <td><strong>{{ $vendor->name }}</strong></td>
                    <td>{{ $vendor->email }}</td>
                    <td>
                        @if($vendor->status == 'active')
                        <span class="badge badge-active">Actif</span>
                        @else
                        <span class="badge badge-suspended">Suspendu</span>
                        @endif
                    </td>
                    <td style="color:#64748b;font-size:13px">{{ $vendor->created_at->format('d/m/Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center;color:#64748b;padding:30px">Aucun vendeur</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</body>
</html>