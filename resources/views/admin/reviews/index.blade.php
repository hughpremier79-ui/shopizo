<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gestion Avis</title>
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
.page-title { font-size: 24px; font-weight: 700; margin-bottom: 30px; }
.btn { display: inline-block; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 600; border: none; cursor: pointer; }
.btn-sm { padding: 5px 10px; font-size: 12px; }
.btn-red { background: #ef4444; color: white; }
.btn-green { background: #25D366; color: white; }
.card { background: white; border-radius: 12px; padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); margin-bottom: 20px; }
.badge { display: inline-block; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; }
.badge-pending { background: #fef3c7; color: #d97706; }
.badge-approved { background: #dcfce7; color: #16a34a; }
.alert-success { background: #dcfce7; border-left: 4px solid #25D366; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; color: #16a34a; font-size: 14px; }
table { width: 100%; border-collapse: collapse; }
th { text-align: left; padding: 12px 15px; font-size: 13px; color: #64748b; border-bottom: 2px solid #f1f5f9; }
td { padding: 12px 15px; font-size: 14px; border-bottom: 1px solid #f8fafc; vertical-align: middle; }
</style>
</head>
<body>

<div class="sidebar">
    <a href="/admin" class="sidebar-brand">Shopi<span>zo</span></a>
    <span class="sidebar-badge">ADMIN</span>
    <div class="sidebar-menu">
        <a href="/admin">📊 Dashboard</a>
        <a href="/admin/vendors">👥 Vendeurs</a>
        <a href="/admin/categories">🏷️ Catégories</a>
        <a href="/admin/reviews" class="active">⭐ Avis</a>
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
    <h1 class="page-title">Gestion des Avis</h1>

    @if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Activité</th>
                    <th>Ville</th>
                    <th>Note</th>
                    <th>Avis</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $review)
                <tr>
                    <td><strong>{{ $review->name }}</strong></td>
                    <td>{{ $review->business ?? '—' }}</td>
                    <td>{{ $review->city ?? '—' }}</td>
                    <td style="color:#f59e0b">
                        @for($i = 1; $i <= $review->rating; $i++) ★ @endfor
                    </td>
                    <td style="max-width:200px;color:#64748b;font-size:13px">{{ Str::limit($review->comment, 80) }}</td>
                    <td>
                        @if($review->status == 'approved')
                        <span class="badge badge-approved">Approuvé</span>
                        @else
                        <span class="badge badge-pending">En attente</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;gap:5px">
                            @if($review->status == 'pending')
                            <form method="POST" action="/admin/reviews/{{ $review->id }}/approve" style="display:inline">
                                @csrf
                                <button type="submit" class="btn btn-green btn-sm">Approuver</button>
                            </form>
                            @endif
                            <form method="POST" action="/admin/reviews/{{ $review->id }}" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-red btn-sm">Supprimer</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align:center;color:#64748b;padding:40px">Aucun avis pour le moment</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</body>
</html>