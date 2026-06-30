<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'CMS Hok Cup')</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Outfit:wght@600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('hokcup/css/admin.css') }}">
</head>
<body>
  <div class="admin-shell">
    <aside class="sidebar" id="adminSidebar">
      <div class="sidebar-head">
        <div class="brand-mark">HC</div>
        <div>
          <div class="brand">Hok Cup CMS</div>
          <div class="brand-sub">Landing page & katalog</div>
        </div>
      </div>

      <a class="side-link side-visit" href="{{ route('home') }}" target="_blank"><i class="fas fa-arrow-up-right-from-square"></i> Lihat Website</a>

      <div class="nav-title">Overview</div>
      <a class="side-link @if(request()->routeIs('admin.dashboard')) active @endif" href="{{ route('admin.dashboard') }}"><i class="fas fa-chart-pie"></i> Dashboard</a>
      <a class="side-link @if(request()->routeIs('admin.analytics.*')) active @endif" href="{{ route('admin.analytics.index') }}"><i class="fas fa-chart-line"></i> Visitor Analytics</a>
      <a class="side-link @if(request()->routeIs('admin.analytics-ads.*')) active @endif" href="{{ route('admin.analytics-ads.edit') }}"><i class="fas fa-bullseye"></i> Tracking & Ads</a>
      <a class="side-link @if(request()->routeIs('admin.seo.*')) active @endif" href="{{ route('admin.seo.edit') }}"><i class="fas fa-magnifying-glass-chart"></i> SEO</a>
      <a class="side-link @if(request()->routeIs('admin.site-settings.*')) active @endif" href="{{ route('admin.site-settings.edit') }}"><i class="fas fa-gear"></i> Site Setting & WA</a>

      <div class="nav-title">Landing Page</div>
      <a class="side-link @if(request()->routeIs('admin.hero.*')) active @endif" href="{{ route('admin.hero.edit') }}"><i class="fas fa-wand-magic-sparkles"></i> Hero Section</a>
      <a class="side-link @if(request()->routeIs('admin.features.*')) active @endif" href="{{ route('admin.features.index') }}"><i class="fas fa-medal"></i> Keunggulan</a>
      <a class="side-link @if(request()->routeIs('admin.about.*')) active @endif" href="{{ route('admin.about.edit') }}"><i class="fas fa-building"></i> Tentang</a>
      <a class="side-link @if(request()->routeIs('admin.social-widgets.*')) active @endif" href="{{ route('admin.social-widgets.index') }}"><i class="fas fa-star"></i> Social Proof</a>
      <a class="side-link @if(request()->routeIs('admin.social-media-links.*')) active @endif" href="{{ route('admin.social-media-links.index') }}"><i class="fas fa-hashtag"></i> Sosial Media</a>
      <a class="side-link @if(request()->routeIs('admin.google-map.*')) active @endif" href="{{ route('admin.google-map.edit') }}"><i class="fas fa-map-location-dot"></i> Google Maps</a>
      <a class="side-link @if(request()->routeIs('admin.cta.*')) active @endif" href="{{ route('admin.cta.edit') }}"><i class="fas fa-bullhorn"></i> CTA</a>

      <div class="nav-title">Katalog</div>
      <a class="side-link @if(request()->routeIs('admin.categories.*')) active @endif" href="{{ route('admin.categories.index') }}"><i class="fas fa-layer-group"></i> Kategori</a>
      <a class="side-link @if(request()->routeIs('admin.products.*')) active @endif" href="{{ route('admin.products.index') }}"><i class="fas fa-box-open"></i> Produk</a>
      <a class="side-link @if(request()->routeIs('admin.footer-links.*')) active @endif" href="{{ route('admin.footer-links.index') }}"><i class="fas fa-link"></i> Footer Links</a>

      <form action="{{ route('logout') }}" method="POST" class="logout-form">
        @csrf
        <button class="btn btn-ghost" type="submit"><i class="fas fa-right-from-bracket"></i> Logout</button>
      </form>
    </aside>

    <div class="sidebar-backdrop" id="sidebarBackdrop" onclick="toggleAdminSidebar(false)"></div>

    <main class="main">
      <div class="mobile-topbar">
        <button class="icon-btn" type="button" onclick="toggleAdminSidebar(true)" aria-label="Buka menu admin"><i class="fas fa-bars"></i></button>
        <strong>Hok Cup CMS</strong>
        <a class="icon-btn" href="{{ route('home') }}" target="_blank" aria-label="Lihat website"><i class="fas fa-globe"></i></a>
      </div>

      <div class="topbar">
        <div class="page-title">
          <span class="page-kicker">Admin Panel</span>
          <h1>@yield('page_title', 'CMS')</h1>
          <p>@yield('page_description', 'Kelola konten website.')</p>
        </div>
        <div class="topbar-action">@yield('page_action')</div>
      </div>

      @if(session('success'))<div class="success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>@endif
      @if($errors->any())<div class="danger"><strong>Periksa kembali input:</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
      @yield('content')
    </main>
  </div>

  <script>
    function toggleAdminSidebar(force){
      const sidebar = document.getElementById('adminSidebar');
      const backdrop = document.getElementById('sidebarBackdrop');
      const open = typeof force === 'boolean' ? force : !sidebar.classList.contains('open');
      sidebar.classList.toggle('open', open);
      backdrop.classList.toggle('open', open);
      document.body.classList.toggle('sidebar-open', open);
    }
  </script>
  @stack('scripts')
</body>
</html>
