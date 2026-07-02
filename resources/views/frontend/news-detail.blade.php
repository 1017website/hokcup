@php
  $siteName = $siteSetting?->site_name ?? 'Hok Cup';
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $article->title }} - {{ $siteName }}</title>
  <meta name="description" content="{{ $article->excerpt ?: $siteSetting?->meta_description }}" />
  <meta property="og:title" content="{{ $article->title }}" />
  <meta property="og:description" content="{{ $article->excerpt ?: $siteSetting?->meta_description }}" />
  <meta property="og:image" content="{{ $article->image_url ?: ($siteSetting?->og_image_url ?? $siteSetting?->logo_url ?? '') }}" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="{{ asset('hokcup/css/frontend.css') }}">
</head>
<body>
  <nav class="nav">
    <div class="nav-inner">
      <a href="{{ route('home') }}" class="brand"><img src="{{ $siteSetting?->logo_url ?? '' }}" alt="{{ $siteName }}"><div class="brand-copy"><strong>{{ $siteName }}</strong><span>{{ $siteSetting?->brand_tagline ?? 'Food Grade Packaging' }}</span></div></a>
      <div class="nav-links"><a href="{{ route('home') }}#produk">Produk</a><a href="{{ route('home') }}#news">News</a><a href="{{ route('home') }}#karir">Karir</a><a href="{{ route('home') }}#kontak">Kontak</a></div>
      <div class="nav-actions"><a href="{{ route('home') }}" class="btn btn-primary"><i class="fas fa-home"></i> Website</a></div>
    </div>
  </nav>

  <main class="detail-page">
    <section class="section">
      <div class="container detail-wrap">
        <a class="back-link" href="{{ route('home') }}#news"><i class="fas fa-arrow-left"></i> Kembali ke News</a>
        <article class="detail-article">
          <div class="detail-kicker"><i class="fas fa-newspaper"></i> News @if($article->published_at) · {{ $article->published_at->format('d M Y') }} @endif @if($article->author) · {{ $article->author }} @endif</div>
          <h1>{{ $article->title }}</h1>
          @if($article->excerpt)<p class="detail-lead">{{ $article->excerpt }}</p>@endif
          @if($article->image_url)<img class="detail-hero-img" src="{{ $article->image_url }}" alt="{{ $article->title }}">@endif
          <div class="detail-content">{!! $article->content !!}</div>
        </article>

        @if($relatedArticles->isNotEmpty())
          <div class="related-box">
            <h2>News Lainnya</h2>
            <div class="news-grid">
              @foreach($relatedArticles as $related)
                <article class="news-card">
                  <a class="news-image" href="{{ route('news.show',$related) }}">
                    @if($related->image_url)<img src="{{ $related->image_url }}" alt="{{ $related->title }}">@else<div class="news-image-placeholder"><i class="fas fa-newspaper"></i></div>@endif
                  </a>
                  <div class="news-body"><small>{{ $related->published_at?->format('d M Y') ?: 'News' }}</small><h3><a href="{{ route('news.show',$related) }}">{{ $related->title }}</a></h3><p>{{ $related->short_excerpt }}</p></div>
                </article>
              @endforeach
            </div>
          </div>
        @endif
      </div>
    </section>
  </main>
</body>
</html>
