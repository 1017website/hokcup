@extends('admin.layout')
@section('title','Dashboard CMS')
@section('page_title','Dashboard')
@section('page_description','Ringkasan konten, total pengunjung, status SEO, tracking, dan modul penting website Hok Cup.')
@section('page_action')
  <a class="btn btn-light" href="{{ route('home') }}" target="_blank"><i class="fas fa-globe"></i> Preview Website</a>
@endsection
@section('content')
<div class="stat-grid stat-grid-4">
  <div class="stat-card"><i class="fas fa-users"></i><strong>{{ number_format($totalVisitors) }}</strong><span>Total Pengunjung</span></div>
  <div class="stat-card"><i class="fas fa-eye"></i><strong>{{ number_format($totalViews) }}</strong><span>Total Page View</span></div>
  <div class="stat-card"><i class="fas fa-box-open"></i><strong>{{ $productCount }}</strong><span>Total Produk</span></div>
  <div class="stat-card"><i class="fas fa-check-circle"></i><strong>{{ $activeProductCount }}</strong><span>Produk Aktif</span></div>
</div>

<div class="stat-grid stat-grid-4">
  <div class="stat-card stat-card-soft"><i class="fas fa-user-check"></i><strong>{{ number_format($todayVisitors) }}</strong><span>Pengunjung Hari Ini</span></div>
  <div class="stat-card stat-card-soft"><i class="fas fa-chart-simple"></i><strong>{{ number_format($todayViews) }}</strong><span>Views Hari Ini</span></div>
  <div class="stat-card stat-card-soft"><i class="fas fa-layer-group"></i><strong>{{ $categoryCount }}</strong><span>Kategori</span></div>
  <div class="stat-card stat-card-soft"><i class="fas fa-hashtag"></i><strong>{{ $socialMediaCount }}</strong><span>Sosial Media Aktif</span></div>
</div>

<div class="grid grid-3">
  <div class="card">
    <h3>CS WhatsApp</h3>
    <p class="help">Tombol WA dibagi rata ke CS aktif dengan sistem round-robin berbasis jumlah click.</p>
    <div class="card-mini card-mini-full">
      <i class="fab fa-whatsapp"></i>
      <div><strong>{{ $activeWhatsappCsCount }} CS Aktif</strong><span>{{ number_format($whatsappClickCount) }} total click WA · fallback: {{ $setting->whatsapp_number ?: 'Belum diisi' }}</span></div>
    </div>
    <div style="margin-top:16px"><a class="btn btn-primary" href="{{ route('admin.whatsapp-cs.index') }}"><i class="fab fa-whatsapp"></i> Kelola CS WhatsApp</a></div>
  </div>

  <div class="card">
    <h3>SEO</h3>
    <p class="help">Pantau kelengkapan meta title, description, OG image, dan robots.</p>
    <div class="status-list status-list-compact" style="margin-top:16px">
      @foreach($seoItems as $label => $enabled)
        <div class="status-item"><strong>{{ $label }}</strong><span class="pill {{ $enabled ? 'pill-green' : 'pill-red' }}">{{ $enabled ? 'Siap' : 'Belum' }}</span></div>
      @endforeach
    </div>
    <div style="margin-top:16px"><a class="btn btn-primary" href="{{ route('admin.seo.edit') }}"><i class="fas fa-magnifying-glass-chart"></i> Atur SEO</a></div>
  </div>

  <div class="card">
    <h3>Analytics & Ads</h3>
    <p class="help">Status pemasangan Google Analytics, GTM, Meta Pixel, Google Ads, dan script custom.</p>
    <div class="status-list status-list-compact" style="margin-top:16px">
      @foreach($trackingItems as $label => $enabled)
        <div class="status-item"><strong>{{ $label }}</strong><span class="pill {{ $enabled ? 'pill-green' : 'pill-red' }}">{{ $enabled ? 'Terpasang' : 'Belum' }}</span></div>
      @endforeach
    </div>
    <div style="margin-top:16px"><a class="btn btn-primary" href="{{ route('admin.analytics-ads.edit') }}"><i class="fas fa-bullseye"></i> Atur Tracking</a></div>
  </div>
</div>

<div class="grid grid-2">
  <div class="card card-soft">
    <h3>Status Modul Frontend</h3>
    <div class="grid grid-2">
      <div class="status-item"><strong>Social Proof Widget</strong><span class="pill pill-green">{{ $socialWidgetCount }} Widget</span></div>
      <div class="status-item"><strong>Google Maps</strong><span class="pill {{ $googleMapIsActive ? 'pill-green' : 'pill-red' }}">{{ $googleMapIsActive ? 'Aktif' : 'Nonaktif' }}</span></div>
      <div class="status-item"><strong>Keunggulan</strong><span class="pill pill-green">{{ $featureCount }} Item</span></div>
      <div class="status-item"><strong>CS WhatsApp</strong><span class="pill {{ $activeWhatsappCsCount > 0 ? 'pill-green' : 'pill-red' }}">{{ $activeWhatsappCsCount }} Aktif</span></div>
      <div class="status-item"><strong>User CMS</strong><span class="pill pill-green">{{ $userCount }} User</span></div>
      <div class="status-item"><strong>Developer</strong><span class="pill pill-green">{{ $developerCount }} Akun</span></div>
    </div>
  </div>

  <div class="card">
    <h3>Langkah Cepat</h3>
    <div class="grid grid-2">
      <a class="btn btn-light" href="{{ route('admin.analytics.index') }}"><i class="fas fa-chart-line"></i> Visitor Analytics</a>
      <a class="btn btn-light" href="{{ route('admin.seo.edit') }}"><i class="fas fa-magnifying-glass-chart"></i> SEO</a>
      <a class="btn btn-light" href="{{ route('admin.products.index') }}"><i class="fas fa-box"></i> Kelola Produk</a>
      <a class="btn btn-light" href="{{ route('admin.whatsapp-cs.index') }}"><i class="fab fa-whatsapp"></i> CS WhatsApp</a>
      <a class="btn btn-light" href="{{ route('admin.social-media-links.index') }}"><i class="fas fa-hashtag"></i> Sosial Media</a>
      <a class="btn btn-light" href="{{ route('admin.google-map.edit') }}"><i class="fas fa-map-location-dot"></i> Google Maps</a>
      <a class="btn btn-light" href="{{ route('admin.commands.index') }}"><i class="fas fa-terminal"></i> Artisan Command</a>
      <a class="btn btn-light" href="{{ route('admin.users.index') }}"><i class="fas fa-users-gear"></i> User CMS</a>
      <a class="btn btn-light" href="{{ route('admin.profile.password.edit') }}"><i class="fas fa-key"></i> Ubah Password</a>
    </div>
  </div>
</div>
@endsection
