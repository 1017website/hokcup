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
  <link rel="stylesheet" href="{{ asset('hokcup/css/admin.css') }}?v=15">
</head>
<body>
@php
  $adminSetting = \App\Models\SiteSetting::query()->first();
  $adminBrandName = $adminSetting?->site_name ?: 'Hok Cup';
  $adminBrandTagline = $adminSetting?->brand_tagline ?: 'Landing page & katalog';
  $adminLogo = $adminSetting?->logo_url;
  $adminInitials = collect(explode(' ', trim($adminBrandName)))
      ->filter()
      ->take(2)
      ->map(fn ($word) => mb_substr($word, 0, 1))
      ->implode('');
  $adminInitials = strtoupper($adminInitials ?: 'HC');
@endphp
  <div class="admin-shell">
    <aside class="sidebar" id="adminSidebar">
      <div class="sidebar-head">
        <div class="brand-mark {{ $adminLogo ? 'image' : '' }}">
          @if($adminLogo)
            <img src="{{ $adminLogo }}" alt="{{ $adminBrandName }} CMS Logo">
          @else
            {{ $adminInitials }}
          @endif
        </div>
        <div>
          <div class="brand">{{ $adminBrandName }} CMS</div>
          <div class="brand-sub">{{ $adminBrandTagline }}</div>
        </div>
      </div>

      <a class="side-link side-visit" href="{{ route('home') }}" target="_blank"><i class="fas fa-arrow-up-right-from-square"></i> Lihat Website</a>

      <div class="nav-title">Overview</div>
      <a class="side-link @if(request()->routeIs('admin.dashboard')) active @endif" href="{{ route('admin.dashboard') }}"><i class="fas fa-chart-pie"></i> Dashboard</a>
      <a class="side-link @if(request()->routeIs('admin.analytics.*')) active @endif" href="{{ route('admin.analytics.index') }}"><i class="fas fa-chart-line"></i> Visitor Analytics</a>
      <a class="side-link @if(request()->routeIs('admin.analytics-ads.*')) active @endif" href="{{ route('admin.analytics-ads.edit') }}"><i class="fas fa-bullseye"></i> Tracking & Ads</a>
      <a class="side-link @if(request()->routeIs('admin.seo.*')) active @endif" href="{{ route('admin.seo.edit') }}"><i class="fas fa-magnifying-glass-chart"></i> SEO</a>
      <a class="side-link @if(request()->routeIs('admin.site-settings.*')) active @endif" href="{{ route('admin.site-settings.edit') }}"><i class="fas fa-gear"></i> Site Setting & WA</a>
      <a class="side-link @if(request()->routeIs('admin.whatsapp-cs.*')) active @endif" href="{{ route('admin.whatsapp-cs.index') }}"><i class="fab fa-whatsapp"></i> CS WhatsApp</a>
      <a class="side-link @if(request()->routeIs('admin.commands.*')) active @endif" href="{{ route('admin.commands.index') }}"><i class="fas fa-terminal"></i> Artisan Command</a>

      <div class="nav-title">Akses CMS</div>
      <a class="side-link @if(request()->routeIs('admin.users.*')) active @endif" href="{{ route('admin.users.index') }}"><i class="fas fa-users-gear"></i> User CMS</a>
      <a class="side-link @if(request()->routeIs('admin.profile.password.*')) active @endif" href="{{ route('admin.profile.password.edit') }}"><i class="fas fa-key"></i> Ubah Password</a>

      <div class="nav-title">Landing Page</div>
      <a class="side-link @if(request()->routeIs('admin.hero.*')) active @endif" href="{{ route('admin.hero.edit') }}"><i class="fas fa-wand-magic-sparkles"></i> Hero Section</a>
      <a class="side-link @if(request()->routeIs('admin.features.*')) active @endif" href="{{ route('admin.features.index') }}"><i class="fas fa-medal"></i> Keunggulan</a>
      <a class="side-link @if(request()->routeIs('admin.about.*')) active @endif" href="{{ route('admin.about.edit') }}"><i class="fas fa-building"></i> Tentang</a>
      <a class="side-link @if(request()->routeIs('admin.social-widgets.*')) active @endif" href="{{ route('admin.social-widgets.index') }}"><i class="fas fa-star"></i> Social Proof</a>
      <a class="side-link @if(request()->routeIs('admin.social-media-links.*')) active @endif" href="{{ route('admin.social-media-links.index') }}"><i class="fas fa-hashtag"></i> Sosial Media</a>
      <a class="side-link @if(request()->routeIs('admin.news.*')) active @endif" href="{{ route('admin.news.index') }}"><i class="fas fa-newspaper"></i> News</a>
      <a class="side-link @if(request()->routeIs('admin.careers.*')) active @endif" href="{{ route('admin.careers.index') }}"><i class="fas fa-briefcase"></i> Karir</a>
      <a class="side-link @if(request()->routeIs('admin.cta.*')) active @endif" href="{{ route('admin.cta.edit') }}"><i class="fas fa-bullhorn"></i> CTA</a>

      <div class="nav-title">Katalog</div>
      <a class="side-link @if(request()->routeIs('admin.categories.*')) active @endif" href="{{ route('admin.categories.index') }}"><i class="fas fa-layer-group"></i> Kategori</a>
      <a class="side-link @if(request()->routeIs('admin.products.*')) active @endif" href="{{ route('admin.products.index') }}"><i class="fas fa-box-open"></i> Produk</a>
      <a class="side-link @if(request()->routeIs('admin.footer-links.*')) active @endif" href="{{ route('admin.footer-links.index') }}"><i class="fas fa-link"></i> Footer Links</a>

      <div class="sidebar-user">
        <div class="sidebar-user-avatar">{{ strtoupper(mb_substr(auth()->user()->name ?? 'U', 0, 1)) }}</div>
        <div>
          <strong>{{ auth()->user()->name }}</strong>
          <span>{{ ucfirst(auth()->user()->role ?? 'Admin') }}</span>
        </div>
      </div>

      <form action="{{ route('logout') }}" method="POST" class="logout-form">
        @csrf
        <button class="btn btn-ghost" type="submit"><i class="fas fa-right-from-bracket"></i> Logout</button>
      </form>
    </aside>

    <div class="sidebar-backdrop" id="sidebarBackdrop" onclick="toggleAdminSidebar(false)"></div>

    <main class="main">
      <div class="mobile-topbar">
        <button class="icon-btn" type="button" onclick="toggleAdminSidebar(true)" aria-label="Buka menu admin"><i class="fas fa-bars"></i></button>
        <div class="mobile-brand">
          <div class="brand-mark mobile-brand-mark {{ $adminLogo ? 'image' : '' }}">
            @if($adminLogo)
              <img src="{{ $adminLogo }}" alt="{{ $adminBrandName }} CMS Logo">
            @else
              {{ $adminInitials }}
            @endif
          </div>
          <strong>{{ $adminBrandName }} CMS</strong>
        </div>
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
