@php
  $siteName = $siteSetting?->site_name ?? 'Hok Cup';
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>News - {{ $siteName }}</title>
  <meta name="description" content="Update terbaru, artikel, dan informasi dari {{ $siteName }}." />
  <meta property="og:title" content="News - {{ $siteName }}" />
  <meta property="og:description" content="Update terbaru, artikel, dan informasi dari {{ $siteName }}." />
  <meta property="og:image" content="{{ $siteSetting?->og_image_url ?? $siteSetting?->logo_url ?? '' }}" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="{{ asset('hokcup/css/frontend.css') }}?v=15">
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
        <a href="{{ route('news.index') }}" class="active-page">News</a>
        <a href="{{ route('careers.index') }}">Karir</a>
        <a href="{{ route('home') }}#kontak">Kontak</a>
      </div>
      <div class="nav-actions"><a href="{{ route('home') }}" class="btn btn-primary"><i class="fas fa-home"></i> Website</a></div>
    </div>
  </nav>

  <main class="listing-page">
    <section class="listing-hero">
      <div class="container listing-hero-inner">
        <a class="back-link" href="{{ route('home') }}"><i class="fas fa-arrow-left"></i> Kembali ke Website</a>
        <span class="eyebrow"><i class="fas fa-newspaper"></i> News & Artikel</span>
        <h1 class="title">Update Terbaru {{ $siteName }}</h1>
        <p class="lead">Kumpulan artikel, berita, promo editorial, dan informasi terbaru yang dapat dibaca pengunjung.</p>
      </div>
    </section>

    <section class="section listing-section">
      <div class="container">
        <div class="news-grid listing-grid">
          @forelse($articles as $article)
            <article class="news-card listing-card">
              <a class="news-image" href="{{ route('news.show',$article) }}">
                @if($article->image_url)
                  <img src="{{ $article->image_url }}" alt="{{ $article->title }}" loading="lazy">
                @else
                  <div class="news-image-placeholder"><i class="fas fa-newspaper"></i></div>
                @endif
                @if($article->is_featured)<span>Featured</span>@endif
              </a>
              <div class="news-body">
                <small>{{ $article->published_at?->format('d M Y') ?: 'News' }} @if($article->author) · {{ $article->author }} @endif</small>
                <h3><a href="{{ route('news.show',$article) }}">{{ $article->title }}</a></h3>
                <p>{{ $article->short_excerpt }}</p>
                <a class="text-link" href="{{ route('news.show',$article) }}">Baca Selengkapnya <i class="fas fa-arrow-right"></i></a>
              </div>
            </article>
          @empty
            <div class="frontend-empty-state">
              <i class="fas fa-newspaper"></i>
              <strong>Belum ada news aktif</strong>
              <span>Tambahkan artikel dari CMS agar tampil di halaman ini.</span>
            </div>
          @endforelse
        </div>

        @if($articles->hasPages())
          <div class="frontend-pagination">
            @if($articles->onFirstPage())
              <span class="page-disabled"><i class="fas fa-chevron-left"></i></span>
            @else
              <a href="{{ $articles->previousPageUrl() }}"><i class="fas fa-chevron-left"></i></a>
            @endif

            @foreach($articles->getUrlRange(1, $articles->lastPage()) as $page => $url)
              @if($page == $articles->currentPage())
                <span class="active">{{ $page }}</span>
              @else
                <a href="{{ $url }}">{{ $page }}</a>
              @endif
            @endforeach

            @if($articles->hasMorePages())
              <a href="{{ $articles->nextPageUrl() }}"><i class="fas fa-chevron-right"></i></a>
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
