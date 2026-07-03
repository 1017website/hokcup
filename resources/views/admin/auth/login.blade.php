@php
  $loginSetting = \App\Models\SiteSetting::query()->first();
  $loginFavicon = $loginSetting?->favicon_url ?: ($loginSetting?->logo_url ?? null);
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @if($loginFavicon)
    <link rel="icon" href="{{ $loginFavicon }}">
    <link rel="shortcut icon" href="{{ $loginFavicon }}">
    <link rel="apple-touch-icon" href="{{ $loginFavicon }}">
  @endif
  <title>Login CMS Hok Cup</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Outfit:wght@700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('hokcup/css/admin.css') }}?v=16">
</head>
<body class="login-page">
  <form class="card login-card" method="POST" action="{{ route('login.post') }}">
    @csrf
    <div class="login-logo">HC</div>
    <h1>Login CMS</h1>
    <p class="help">Masuk menggunakan akun CMS yang sudah diberikan oleh administrator.</p>
    @if($errors->any())<div class="danger">{{ $errors->first() }}</div>@endif
    <div class="field"><label>Email</label><input type="email" name="email" value="{{ old('email') }}" required autofocus></div><br>
    <div class="field"><label>Password</label><input type="password" name="password" required></div><br>
    <label style="display:flex;gap:8px;align-items:center;font-weight:800"><input type="checkbox" name="remember" value="1"> Ingat saya</label><br>
    <button class="btn btn-primary">Login</button>
  </form>
</body>
</html>
