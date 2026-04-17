<!DOCTYPE html>
<html lang="fr">
 <link rel="manifest" href="/manifest.json">
<meta name="theme-color" content="#25D366">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<meta name="apple-mobile-web-app-title" content="Shopizo">
<script>
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('/sw.js');
    });
}
</script>   
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Shopizo')</title>
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: 'Segoe UI', sans-serif; background: #f8fafc; color: #1e293b; }
.navbar { background: #fff; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 10px rgba(0,0,0,0.08); position: sticky; top: 0; z-index: 100; }
.navbar-brand { font-size: 22px; font-weight: 700; color: #25D366; text-decoration: none; }
.navbar-brand span { color: #1e293b; }
.navbar-links a { color: #64748b; text-decoration: none; margin-left: 20px; font-size: 14px; }
.navbar-links a:hover { color: #25D366; }
.btn { display: inline-block; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 600; cursor: pointer; border: none; }
.btn-green { background: #25D366; color: white; }
.btn-blue { background: #3b82f6; color: white; }
.btn-red { background: #ef4444; color: white; }
.btn-orange { background: #f59e0b; color: white; }
.btn:hover { opacity: 0.9; }
.container { max-width: 1100px; margin: 0 auto; padding: 30px 20px; }
.card { background: #fff; border-radius: 12px; padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); }
.footer { background: #1e293b; color: #94a3b8; text-align: center; padding: 20px; margin-top: 50px; font-size: 14px; }
</style>
</head>
<body>
<nav class="navbar">
<a href="/" class="navbar-brand">Shopi<span>zo</span></a>
<div class="navbar-links">
<a href="/tarifs">Tarifs</a>
<a href="/contact">Contact</a>
<a href="/avis">Avis</a>
<a href="/login">Connexion</a>
<a href="/register" class="btn btn-green" style="padding:8px 16px">S'inscrire</a>
</div>
</nav>
@yield('content')
<footer class="footer">
<p>Shopizo — Shopizo © 2026</p>
</footer>
</body>
</html>