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
    <h3>Nomor WhatsApp</h3>
    <p class="help">Nomor WA yang dipakai tombol navbar, CTA, floating button, dan detail produk.</p>
    <div class="card-mini card-mini-full">
      <i class="fab fa-whatsapp"></i>
      <div><strong>{{ $setting->whatsapp_number ?: 'Belum diisi' }}</strong><span>Format: 628xxxxxxxxxx tanpa tanda plus</span></div>
    </div>
    <div style="margin-top:16px"><a class="btn btn-primary" href="{{ route('admin.site-settings.edit') }}"><i class="fas fa-gear"></i> Atur Nomor WA</a></div>
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
      <div class="status-item"><strong>Kontak WA</strong><span class="pill {{ filled($setting->whatsapp_number) ? 'pill-green' : 'pill-red' }}">{{ filled($setting->whatsapp_number) ? 'Siap' : 'Belum' }}</span></div>
    </div>
  </div>

  <div class="card">
    <h3>Langkah Cepat</h3>
    <div class="grid grid-2">
      <a class="btn btn-light" href="{{ route('admin.analytics.index') }}"><i class="fas fa-chart-line"></i> Visitor Analytics</a>
      <a class="btn btn-light" href="{{ route('admin.seo.edit') }}"><i class="fas fa-magnifying-glass-chart"></i> SEO</a>
      <a class="btn btn-light" href="{{ route('admin.products.index') }}"><i class="fas fa-box"></i> Kelola Produk</a>
      <a class="btn btn-light" href="{{ route('admin.site-settings.edit') }}"><i class="fab fa-whatsapp"></i> Nomor WA</a>
      <a class="btn btn-light" href="{{ route('admin.social-media-links.index') }}"><i class="fas fa-hashtag"></i> Sosial Media</a>
      <a class="btn btn-light" href="{{ route('admin.google-map.edit') }}"><i class="fas fa-map-location-dot"></i> Google Maps</a>
      <a class="btn btn-light" href="{{ route('admin.commands.index') }}"><i class="fas fa-terminal"></i> Artisan Command</a>
    </div>
  </div>
</div>
@endsection
