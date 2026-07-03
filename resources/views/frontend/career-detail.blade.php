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
  <title>{{ $career->title }} - Karir {{ $siteName }}</title>
  <meta name="description" content="{{ $career->summary ?: 'Lowongan karir '.$siteName }}" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="{{ asset('hokcup/css/frontend.css') }}?v=16">
</head>
<body>
  <nav class="nav">
    <div class="nav-inner">
      <a href="{{ route('home') }}" class="brand"><img src="{{ $siteSetting?->logo_url ?? '' }}" alt="{{ $siteName }}"><div class="brand-copy"><strong>{{ $siteName }}</strong><span>{{ $siteSetting?->brand_tagline ?? 'Food Grade Packaging' }}</span></div></a>
      <div class="nav-links"><a href="{{ route('home') }}#produk">Produk</a><a href="{{ route('news.index') }}">News</a><a href="{{ route('careers.index') }}">Karir</a><a href="{{ route('home') }}#kontak">Kontak</a></div>
      <div class="nav-actions"><a href="{{ route('home') }}" class="btn btn-primary"><i class="fas fa-home"></i> Website</a></div>
    </div>
  </nav>

  <main class="detail-page">
    <section class="section">
      <div class="container detail-wrap">
        <a class="back-link" href="{{ route('careers.index') }}"><i class="fas fa-arrow-left"></i> Kembali ke Karir</a>
        <article class="detail-article career-detail-box">
          <div class="detail-kicker"><i class="fas fa-briefcase"></i> Karir @if($career->department) · {{ $career->department }} @endif</div>
          <h1>{{ $career->title }}</h1>
          @if($career->summary)<p class="detail-lead">{{ $career->summary }}</p>@endif
          <div class="career-meta career-meta-large">
            @if($career->location)<span><i class="fas fa-location-dot"></i> {{ $career->location }}</span>@endif
            @if($career->employment_type)<span><i class="fas fa-clock"></i> {{ $career->employment_type }}</span>@endif
            @if($career->work_type)<span><i class="fas fa-building-user"></i> {{ $career->work_type }}</span>@endif
            @if($career->salary_range)<span><i class="fas fa-money-bill-wave"></i> {{ $career->salary_range }}</span>@endif
            @if($career->closes_at)<span><i class="fas fa-calendar"></i> Deadline {{ $career->closes_at->format('d M Y') }}</span>@endif
          </div>
          @if($career->description)
            <h2>Deskripsi Pekerjaan</h2>
            <div class="detail-content">{!! $career->description !!}</div>
          @endif
          @if($career->requirements)
            <h2>Kualifikasi</h2>
            <div class="detail-content">{!! $career->requirements !!}</div>
          @endif
          @if($career->apply_link)
            <div class="detail-apply"><a class="btn btn-primary" href="{{ $career->apply_link }}" target="_blank" rel="noopener"><i class="fas fa-paper-plane"></i> Lamar Posisi Ini</a></div>
          @endif
        </article>
      </div>
    </section>
  </main>
</body>
</html>
