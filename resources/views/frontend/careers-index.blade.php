@php
  $siteName = $siteSetting?->site_name ?? 'Hok Cup';
  $faviconUrl = $siteSetting?->favicon_url ?: ($siteSetting?->logo_url ?? null);
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  @if($faviconUrl)
    <link rel="icon" href="{{ $faviconUrl }}">
    <link rel="shortcut icon" href="{{ $faviconUrl }}">
    <link rel="apple-touch-icon" href="{{ $faviconUrl }}">
  @endif
  <title>Karir - {{ $siteName }}</title>
  <meta name="description" content="Lowongan karir dan kesempatan bergabung bersama {{ $siteName }}." />
  <meta property="og:title" content="Karir - {{ $siteName }}" />
  <meta property="og:description" content="Lowongan karir dan kesempatan bergabung bersama {{ $siteName }}." />
  <meta property="og:image" content="{{ $siteSetting?->og_image_url ?? $siteSetting?->logo_url ?? '' }}" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="{{ asset('hokcup/css/frontend.css') }}?v=16">
</head>
<body>
  <nav class="nav">
    <div class="nav-inner">
      <a href="{{ route('home') }}" class="brand">
        <img src="{{ $siteSetting?->logo_url ?? '' }}" alt="{{ $siteName }}">
        <div class="brand-copy"><strong>{{ $siteName }}</strong><span>{{ $siteSetting?->brand_tagline ?? 'Food Grade Packaging' }}</span></div>
      </a>
      <div class="nav-links">
        <a href="{{ route('home') }}#kategori">Kategori</a>
        <a href="{{ route('home') }}#produk">Produk</a>
        <a href="{{ route('home') }}#keunggulan">Keunggulan</a>
        <a href="{{ route('home') }}#tentang">Tentang</a>
        <a href="{{ route('news.index') }}">News</a>
        <a href="{{ route('careers.index') }}" class="active-page">Karir</a>
        <a href="{{ route('home') }}#kontak">Kontak</a>
      </div>
      <div class="nav-actions"><a href="{{ route('home') }}" class="btn btn-primary"><i class="fas fa-home"></i> Website</a></div>
    </div>
  </nav>

  <main class="listing-page">
    <section class="listing-hero career-listing-hero">
      <div class="container listing-hero-inner">
        <a class="back-link" href="{{ route('home') }}"><i class="fas fa-arrow-left"></i> Kembali ke Website</a>
        <span class="eyebrow"><i class="fas fa-briefcase"></i> Karir</span>
        <h1 class="title">Bergabung Bersama {{ $siteName }}</h1>
        <p class="lead">Lihat posisi yang tersedia dan pilih kesempatan yang paling sesuai dengan pengalaman Anda.</p>
      </div>
    </section>

    <section class="section listing-section">
      <div class="container">
        <div class="career-grid listing-grid">
          @forelse($careers as $career)
            <article class="career-card listing-card">
              <div class="career-top">
                <div class="career-icon"><i class="fas fa-user-tie"></i></div>
                <div>
                  <small>{{ $career->department ?: 'Karir' }}</small>
                  <h3>{{ $career->title }}</h3>
                </div>
              </div>
              <p>{{ $career->short_summary }}</p>
              <div class="career-meta">
                @if($career->location)<span><i class="fas fa-location-dot"></i> {{ $career->location }}</span>@endif
                @if($career->employment_type)<span><i class="fas fa-clock"></i> {{ $career->employment_type }}</span>@endif
                @if($career->work_type)<span><i class="fas fa-building-user"></i> {{ $career->work_type }}</span>@endif
                @if($career->closes_at)<span><i class="fas fa-calendar"></i> Deadline {{ $career->closes_at->format('d M Y') }}</span>@endif
              </div>
              <div class="career-actions">
                <a class="btn btn-light" href="{{ route('careers.show',$career) }}">Detail</a>
                @if($career->apply_link)
                  <a class="btn btn-primary" href="{{ $career->apply_link }}" target="_blank" rel="noopener"><i class="fas fa-paper-plane"></i> Lamar</a>
                @endif
              </div>
            </article>
          @empty
            <div class="frontend-empty-state">
              <i class="fas fa-briefcase"></i>
              <strong>Belum ada lowongan aktif</strong>
              <span>Tambahkan lowongan dari CMS agar tampil di halaman ini.</span>
            </div>
          @endforelse
        </div>

        @if($careers->hasPages())
          <div class="frontend-pagination">
            @if($careers->onFirstPage())
              <span class="page-disabled"><i class="fas fa-chevron-left"></i></span>
            @else
              <a href="{{ $careers->previousPageUrl() }}"><i class="fas fa-chevron-left"></i></a>
            @endif

            @foreach($careers->getUrlRange(1, $careers->lastPage()) as $page => $url)
              @if($page == $careers->currentPage())
                <span class="active">{{ $page }}</span>
              @else
                <a href="{{ $url }}">{{ $page }}</a>
              @endif
            @endforeach

            @if($careers->hasMorePages())
              <a href="{{ $careers->nextPageUrl() }}"><i class="fas fa-chevron-right"></i></a>
            @else
              <span class="page-disabled"><i class="fas fa-chevron-right"></i></span>
            @endif
          </div>
        @endif
      </div>
    </section>
  </main>
</body>
</html>
