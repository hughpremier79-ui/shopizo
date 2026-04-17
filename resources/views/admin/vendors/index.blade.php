<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gestion Vendeurs</title>
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
.btn-blue { background: #3b82f6; color: white; }
.card { background: white; border-radius: 12px; padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); margin-bottom: 20px; }
table { width: 100%; border-collapse: collapse; }
th { text-align: left; padding: 12px 15px; font-size: 13px; color: #64748b; border-bottom: 2px solid #f1f5f9; }
td { padding: 12px 15px; font-size: 14px; border-bottom: 1px solid #f8fafc; vertical-align: middle; }
.badge { display: inline-block; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; }
.badge-active { background: #dcfce7; color: #16a34a; }
.badge-suspended { background: #fee2e2; color: #dc2626; }
.badge-free { background: #f1f5f9; color: #64748b; }
.badge-standard { background: #dcfce7; color: #16a34a; }
.badge-premium { background: #f3e8ff; color: #7c3aed; }
.alert-success { background: #dcfce7; border-left: 4px solid #25D366; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; color: #16a34a; font-size: 14px; }
.modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center; }
.modal.active { display: flex; }
.modal-box { background: white; border-radius: 16px; padding: 30px; width: 400px; }
.modal-title { font-size: 18px; font-weight: 700; margin-bottom: 20px; }
.form-group { margin-bottom: 15px; }
.form-label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; }
.form-control { width: 100%; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px; }
</style>
</head>
<body>

<div class="sidebar">
    <a href="/admin" class="sidebar-brand">Shopi<span>zo</span></a>
    <span class="sidebar-badge">ADMIN</span>
    <div class="sidebar-menu">
        <a href="/admin">📊 Dashboard</a>
        <a href="/admin/vendors" class="active">👥 Vendeurs</a>
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
    <h1 class="page-title">Gestion des Vendeurs</h1>

    @if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Boutique</th>
                    <th>Statut</th>
                    <th>Plan</th>
                    <th>Expiration</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vendors as $vendor)
                <tr>
                    <td><strong>{{ $vendor->name }}</strong></td>
                    <td>{{ $vendor->email }}</td>
                    <td>{{ $vendor->store ? $vendor->store->name : 'Aucune' }}</td>
                    <td>
                        @if($vendor->status == 'active')
                        <span class="badge badge-active">Actif</span>
                        @else
                        <span class="badge badge-suspended">Suspendu</span>
                        @endif
                    </td>
                    <td>
                        @if($vendor->plan == 'premium')
                        <span class="badge badge-premium">Premium</span>
                        @elseif($vendor->plan == 'standard')
                        <span class="badge badge-standard">Standard</span>
                        @else
                        <span class="badge badge-free">Gratuit</span>
                        @endif
                    </td>
                    <td style="color:#64748b;font-size:13px">
                        {{ $vendor->plan_expires_at ? $vendor->plan_expires_at->format('d/m/Y') : '—' }}
                    </td>
                    <td>
                        <div style="display:flex;gap:5px;flex-wrap:wrap">
                            @if($vendor->status == 'active')
                            <form method="POST" action="/admin/vendors/{{ $vendor->id }}/suspend" style="display:inline">
                                @csrf
                                <button type="submit" class="btn btn-red btn-sm">Suspendre</button>
                            </form>
                            @else
                            <form method="POST" action="/admin/vendors/{{ $vendor->id }}/activate" style="display:inline">
                                @csrf
                                <button type="submit" class="btn btn-green btn-sm">Activer</button>
                            </form>
                            @endif
                            <button onclick="openPlanModal({{ $vendor->id }}, '{{ $vendor->plan }}', '{{ $vendor->plan_expires_at }}')" class="btn btn-blue btn-sm">Plan</button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align:center;color:#64748b;padding:40px">Aucun vendeur</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal" id="plan-modal">
    <div class="modal-box">
        <div class="modal-title">Modifier le plan</div>
        <form method="POST" id="plan-form">
            @csrf
            <div class="form-group">
                <label class="form-label">Plan</label>
                <select name="plan" id="plan-select" class="form-control">
                    <option value="free">Gratuit</option>
                    <option value="standard">Standard — 3 000 FCFA/mois</option>
                    <option value="premium">Premium — 7 000 FCFA/mois</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Date d'expiration</label>
                <input type="date" name="plan_expires_at" id="plan-expires" class="form-control">
            </div>
            <div style="display:flex;gap:10px;margin-top:20px">
                <button type="submit" class="btn btn-green" style="flex:1">Enregistrer</button>
                <button type="button" onclick="closeModal()" class="btn" style="flex:1;background:#f1f5f9;color:#1e293b">Annuler</button>
            </div>
        </form>
    </div>
</div>

<script>
function openPlanModal(vendorId, plan, expires) {
    document.getElementById('plan-form').action = '/admin/vendors/' + vendorId + '/plan';
    document.getElementById('plan-select').value = plan;
    document.getElementById('plan-expires').value = expires ? expires.substring(0, 10) : '';
    document.getElementById('plan-modal').classList.add('active');
}
function closeModal() {
    document.getElementById('plan-modal').classList.remove('active');
}
</script>

</body>
</html>