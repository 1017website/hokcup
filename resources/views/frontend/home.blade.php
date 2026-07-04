@php
  $siteName = $siteSetting?->site_name ?? 'Hok Cup';
  $faviconUrl = $siteSetting?->favicon_url ?: ($siteSetting?->logo_url ?? null);
  $waNumber = $siteSetting?->whatsapp_number ?? '6281234567890'; // fallback jika semua CS WhatsApp nonaktif
  $trackingBaseId = $siteSetting?->google_analytics_id ?: $siteSetting?->google_ads_id;
  $visibleSocialWidgets = collect($socialWidgets ?? [])->filter(fn ($widget) => trim((string) ($widget->embed_code ?? '')) !== '')->values();
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
  <title>{{ $siteSetting?->meta_title ?? $siteName }}</title>
  <meta name="description" content="{{ $siteSetting?->meta_description ?? '' }}" />
  <meta name="keywords" content="{{ $siteSetting?->meta_keywords ?? '' }}" />
  <meta name="robots" content="{{ $siteSetting?->seo_robots ?? 'index, follow' }}" />
  @if($siteSetting?->canonical_url)
    <link rel="canonical" href="{{ $siteSetting->canonical_url }}" />
  @endif
  <meta property="og:type" content="website" />
  <meta property="og:site_name" content="{{ $siteName }}" />
  <meta property="og:title" content="{{ $siteSetting?->meta_title ?? $siteName }}" />
  <meta property="og:description" content="{{ $siteSetting?->meta_description ?? '' }}" />
  <meta property="og:image" content="{{ $siteSetting?->og_image_url ?? $siteSetting?->logo_url ?? '' }}" />
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="{{ $siteSetting?->twitter_title ?: ($siteSetting?->meta_title ?? $siteName) }}" />
  <meta name="twitter:description" content="{{ $siteSetting?->twitter_description ?: ($siteSetting?->meta_description ?? '') }}" />
  <meta name="twitter:image" content="{{ $siteSetting?->twitter_image_url ?: ($siteSetting?->og_image_url ?? $siteSetting?->logo_url ?? '') }}" />
  @if($siteSetting?->schema_json_ld)
    <script type="application/ld+json">{!! $siteSetting->schema_json_ld !!}</script>
  @endif
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  @if($visibleSocialWidgets->isNotEmpty())
    <script src="https://elfsightcdn.com/platform.js" async></script>
  @endif
  @if($trackingBaseId)
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $trackingBaseId }}"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      @if($siteSetting?->google_analytics_id)
        gtag('config', '{{ $siteSetting->google_analytics_id }}');
      @endif
      @if($siteSetting?->google_ads_id)
        gtag('config', '{{ $siteSetting->google_ads_id }}');
      @endif
    </script>
  @endif
  @if($siteSetting?->google_tag_manager_id)
    <script>
      (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','{{ $siteSetting->google_tag_manager_id }}');
    </script>
  @endif
  @if($siteSetting?->meta_pixel_id)
    <script>
      !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window, document,'script','https://connect.facebook.net/en_US/fbevents.js');
      fbq('init', '{{ $siteSetting->meta_pixel_id }}');
      fbq('track', 'PageView');
    </script>
  @endif
  {!! $siteSetting?->head_scripts !!}
  <link rel="stylesheet" href="{{ asset('hokcup/css/frontend.css') }}?v=17">
</head>
<body>
  @if($siteSetting?->google_tag_manager_id)
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $siteSetting->google_tag_manager_id }}" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  @endif
  {!! $siteSetting?->body_start_scripts !!}

  <nav class="nav">
    <div class="nav-inner">
      <a href="#home" class="brand" aria-label="{{ $siteName }} Home">
        <img src="{{ $siteSetting?->logo_url ?? '' }}" alt="{{ $siteName }} Logo">
        <div class="brand-copy"><strong>{{ $siteName }}</strong><span>{{ $siteSetting?->brand_tagline ?? 'Food Grade Packaging' }}</span></div>
      </a>
      <div class="nav-links">
        <a href="#kategori">Kategori</a>
        <a href="#produk">Produk</a>
        <a href="#keunggulan">Keunggulan</a>
        <a href="#tentang">Tentang</a>
        <a href="#sosial-media">Sosial</a>
        <a href="{{ route('news.index') }}">News</a>
        <a href="{{ route('careers.index') }}">Karir</a>
        <a href="#kontak">Kontak</a>
      </div>
      <div class="nav-actions">
        <button class="search-nav-btn" onclick="openSearch()" aria-label="Cari produk"><i class="fas fa-search"></i></button>
        <a href="{{ route('whatsapp.redirect', ['text' => 'Halo '.$siteName.', saya ingin bertanya produk']) }}" target="_blank" class="btn btn-primary"><i class="fab fa-whatsapp"></i> Tanya Produk</a>
        <button class="menu-btn" onclick="toggleMobileMenu()" aria-label="Buka menu"><i class="fas fa-bars"></i></button>
      </div>
    </div>
  </nav>
  <div class="mobile-menu" id="mobileMenu">
    <a onclick="closeMobileMenu()" href="#kategori">Kategori</a>
    <a onclick="closeMobileMenu()" href="#produk">Produk</a>
    <a onclick="closeMobileMenu()" href="#keunggulan">Keunggulan</a>
    <a onclick="closeMobileMenu()" href="#tentang">Tentang</a>
    <a onclick="closeMobileMenu()" href="#sosial-media">Sosial Media</a>
    <a onclick="closeMobileMenu()" href="{{ route('news.index') }}">News</a>
    <a onclick="closeMobileMenu()" href="{{ route('careers.index') }}">Karir</a>
    <a onclick="closeMobileMenu()" href="#kontak">Kontak</a>
    <a onclick="closeMobileMenu(); openSearch();" href="javascript:void(0)"><i class="fas fa-search"></i> Cari Produk</a>
  </div>

  <main id="home">
    <section class="hero">
      <div class="container hero-grid">
        <div>
          <span class="eyebrow"><i class="fas {{ $hero?->eyebrow_icon ?? 'fa-certificate' }}"></i> {{ $hero?->eyebrow_text ?? 'Gelas Plastik Food Grade' }}</span>
          <h1 class="hero-title">{{ $hero?->title_before ?? 'Kemasan' }} <span class="pill-word">{{ $hero?->pill_word ?? 'Hok' }}</span><br>{{ $hero?->title_after ?? 'untuk Bisnis Minuman Anda' }}</h1>
          <p class="hero-desc">{{ $hero?->description ?? '' }}</p>
          <div class="hero-actions">
            <a href="#produk" class="btn btn-primary"><i class="fas {{ $hero?->primary_button_icon ?? 'fa-magnifying-glass' }}"></i> {{ $hero?->primary_button_text ?? 'Cari Produk' }}</a>
            <a href="#kategori" class="btn btn-light"><i class="fas {{ $hero?->secondary_button_icon ?? 'fa-layer-group' }}"></i> {{ $hero?->secondary_button_text ?? 'Lihat Kategori' }}</a>
          </div>
          <div class="trust-row">
            @foreach($trustItems as $item)
              <div class="trust-chip"><i class="fas {{ $item->icon }}"></i> {{ $item->text }}</div>
            @endforeach
          </div>
        </div>
        <div class="hero-visual">
          <div class="product-orbit">
            <div class="floating-logo"><img src="{{ $siteSetting?->logo_url ?? '' }}" alt="{{ $siteName }}"></div>
            <div class="hero-img"><img src="{{ $hero?->image_url ?? '' }}" alt="Minuman dalam gelas plastik"></div>
            <div class="hero-card card-a"><div class="icon"><i class="fas {{ $hero?->card_a_icon ?? 'fa-cup-straw' }}"></i></div><div><strong>{{ $hero?->card_a_number ?? '12+' }}</strong><span>{{ $hero?->card_a_text ?? 'Varian Produk' }}</span></div></div>
            <div class="hero-card card-b"><div class="icon"><i class="fas {{ $hero?->card_b_icon ?? 'fa-store' }}"></i></div><div><strong>{{ $hero?->card_b_number ?? 'UMKM' }}</strong><span>{{ $hero?->card_b_text ?? 'Friendly Packaging' }}</span></div></div>
            <div class="hero-card card-c"><div class="icon"><i class="fas {{ $hero?->card_c_icon ?? 'fa-truck-fast' }}"></i></div><div><strong>{{ $hero?->card_c_number ?? 'Ready' }}</strong><span>{{ $hero?->card_c_text ?? 'Siap Kirim' }}</span></div></div>
          </div>
        </div>
      </div>
    </section>

    <div class="marquee">
      <div class="marquee-track">
        @foreach($categories->concat($categories) as $category)
          <span><i class="fas fa-star"></i> {{ $category->slug === 'grosir' ? 'Jadi Mitra HokCup' : $category->name }}</span>
        @endforeach
      </div>
    </div>

    <section class="section" id="kategori">
      <div class="container">
        <div class="section-head">
          <div>
            <span class="eyebrow"><i class="fas fa-layer-group"></i> Kategori Produk</span>
            <h2 class="title" style="margin-top:16px">Pilih Berdasarkan Kebutuhan</h2>
          </div>
        </div>
        <div class="category-strip" id="categoryTiles"></div>
      </div>
    </section>

    <section class="section catalog" id="produk">
      <div class="container catalog-layout">
        <aside class="filter-panel">
          <span class="eyebrow"><i class="fas fa-sliders"></i> Filter</span>
          <div class="filter-title">Cari Produk</div>
          <div class="searchbox">
            <i class="fas fa-search"></i>
            <input type="search" id="searchInput" placeholder="Cari 12oz, oval, lid..." oninput="renderProducts()">
          </div>
          <div class="filter-title">Kategori</div>
          <div class="filter-list" id="filterList"></div>
          <div class="filter-note">
            <strong>Catatan:</strong> data ukuran, isi, dan fitur dapat diubah dari CMS admin.
          </div>
        </aside>
        <div>
          <div class="catalog-top">
            <div class="result-info">
              <strong id="resultTitle">Semua Produk</strong>
              <span id="resultCount">Menampilkan katalog {{ $siteName }}</span>
            </div>
            <select class="sort-select" id="sortSelect" onchange="renderProducts()">
              <option value="default">Urutan Default</option>
              <option value="name">Nama A-Z</option>
              <option value="size">Ukuran Terkecil</option>
            </select>
          </div>
          <div class="product-grid" id="productGrid"></div>
          <div class="pagination" id="pagination"></div>
          <div class="empty-state" id="emptyState">
            <i class="fas fa-box-open"></i>
            <strong>Produk tidak ditemukan</strong>
            <p>Coba gunakan kata kunci lain seperti 12oz, oval, square, lid, atau kategori lainnya.</p>
          </div>
        </div>
      </div>
    </section>

    <section class="section" id="keunggulan">
      <div class="container">
        <div class="section-head">
          <div>
            <span class="eyebrow"><i class="fas fa-medal"></i> Keunggulan</span>
            <h2 class="title" style="margin-top:16px">Kenapa Memilih {{ $siteName }}?</h2>
          </div>
        </div>
        <div class="feature-grid">
          @foreach($features as $feature)
            <div class="feature-card"><i class="fas {{ $feature->icon }}"></i><h3>{{ $feature->title }}</h3><p>{{ $feature->description }}</p></div>
          @endforeach
        </div>
      </div>
    </section>

    <section class="section" id="tentang">
      <div class="container">
        <div class="about-band">
          <div>
            <span class="eyebrow" style="background:rgba(255,255,255,.09);border-color:rgba(255,255,255,.13);color:var(--yellow)"><i class="fas {{ $about?->eyebrow_icon ?? 'fa-building' }}"></i> {{ $about?->eyebrow_text ?? 'Tentang Hok Cup' }}</span>
            <h2 class="title" style="margin-top:16px">{{ $about?->title ?? '' }}</h2>
            <p class="lead">{{ $about?->description ?? '' }}</p>
            <div class="stat-mini">
              @foreach($aboutStats as $stat)
                <div><strong>{{ $stat->number }}</strong><span>{{ $stat->label }}</span></div>
              @endforeach
            </div>
          </div>
          <div class="about-img"><img src="{{ $about?->image_url ?? '' }}" alt="Outlet minuman"></div>
        </div>
      </div>
    </section>

    @if($socialLinks->isNotEmpty())
      <section class="section social-links-section" id="sosial-media">
        <div class="container">
          <div class="section-head">
            <div>
              <span class="eyebrow"><i class="fas fa-hashtag"></i> Sosial Media</span>
              <h2 class="title" style="margin-top:16px">Ikuti Update {{ $siteName }}</h2>
            </div>
          </div>
          <div class="social-link-grid">
            @foreach($socialLinks as $link)
              <a class="social-link-card" href="{{ $link->url }}" target="_blank" rel="noopener">
                <div class="social-link-icon"><i class="{{ $link->icon }}"></i></div>
                <div>
                  <small>{{ $link->platform }}</small>
                  <strong>{{ $link->label ?: $link->platform }}</strong>
                  @if($link->username)<span>{{ $link->username }}</span>@endif
                  @if($link->description)<p>{{ $link->description }}</p>@endif
                </div>
                <i class="fas fa-arrow-right social-link-arrow"></i>
              </a>
            @endforeach
          </div>
        </div>
      </section>
    @endif

    @if($visibleSocialWidgets->isNotEmpty())
      <section class="section social-section" id="instagram-review">
        <div class="container">
          <div class="section-head">
            <div>
              <span class="eyebrow"><i class="fas fa-heart"></i> Social Proof</span>
              <h2 class="title" style="margin-top:16px">Media Social Update</h2>
            </div>
          </div>
          <div class="social-grid">
            @foreach($visibleSocialWidgets as $widget)
              <div class="social-widget">
                <div class="social-widget-head"><i class="{{ $widget->icon }}"></i><h3>{{ $widget->title }}</h3></div>
                @if($widget->description)<p>{{ $widget->description }}</p>@endif
                {!! $widget->embed_code !!}
              </div>
            @endforeach
          </div>
        </div>
      </section>
    @endif


    {{-- Google Maps sementara disembunyikan. Aktifkan kembali dengan mengubah false menjadi true. --}}
    @if(false && $googleMap)
      <section class="section map-section" id="lokasi">
        <div class="container">
          <div class="map-card">
            <div class="map-copy">
              <span class="eyebrow"><i class="fas {{ $googleMap->eyebrow_icon ?: 'fa-location-dot' }}"></i> {{ $googleMap->eyebrow_text ?: 'Lokasi Kami' }}</span>
              <h2 class="title" style="margin-top:16px">{{ $googleMap->title }}</h2>
              @if($googleMap->description)<p class="lead">{{ $googleMap->description }}</p>@endif
              @if($googleMap->address)
                <div class="map-address"><i class="fas fa-map-pin"></i><span>{{ $googleMap->address }}</span></div>
              @endif
              @if($googleMap->button_url)
                <a class="btn btn-primary" href="{{ $googleMap->button_url }}" target="_blank" rel="noopener"><i class="fas fa-route"></i> {{ $googleMap->button_text ?: 'Buka Google Maps' }}</a>
              @endif
            </div>
            <div class="map-frame">
              @if($googleMap->embed_code)
                {!! $googleMap->embed_code !!}
              @else
                <div class="map-placeholder"><i class="fas fa-map-location-dot"></i><strong>Embed Google Maps belum diisi</strong><span>Tambahkan iframe Google Maps melalui CMS.</span></div>
              @endif
            </div>
          </div>
        </div>
      </section>
    @endif

    <section class="cta" id="kontak">
      <div class="container cta-inner">
        <div>
          <h2 class="title">{{ $cta?->title ?? '' }}</h2>
          <p class="lead">{{ $cta?->description ?? '' }}</p>
        </div>
        <a class="btn btn-light" href="{{ route('whatsapp.redirect', ['text' => ($cta?->whatsapp_message ?: ('Halo '.$siteName.', saya ingin konsultasi produk'))]) }}" target="_blank"><i class="{{ $cta?->button_icon ?? 'fab fa-whatsapp' }}"></i> {{ $cta?->button_text ?? 'Konsultasi WhatsApp' }}</a>
      </div>
    </section>
  </main>

  <footer>
    <div class="container">
      <div class="footer-grid">
        <div class="footer-col">
          <div class="footer-logo"><img src="{{ $siteSetting?->logo_url ?? '' }}" alt="{{ $siteName }}"><strong>{{ $siteName }}</strong></div>
          @if($siteSetting?->brand_tagline)
            <p>{{ $siteSetting->brand_tagline }}</p>
          @endif
        </div>
        @foreach($footerLinks as $group => $links)
          <div class="footer-col"><h4>{{ $group }}</h4>
            @foreach($links as $link)
              <a href="{{ $link->url }}" @if($link->onclick) onclick="{{ $link->onclick }}" @endif>{{ $link->label }}</a>
            @endforeach
          </div>
        @endforeach
        <div class="footer-col"><h4>Kontak</h4><p>WhatsApp: +{{ $waNumber }}</p><p>Email: {{ $siteSetting?->email }}</p><p>Jam Operasional: {{ $siteSetting?->operational_hours }}</p></div>
      </div>
      <div class="copyright"><p>© {{ date('Y') }} {{ $siteName }}. All rights reserved.</p><p>Developed by <span>1017studios.id</span></p></div>
    </div>
  </footer>

  <button class="wa-float" onclick="openWaGeneral()" aria-label="Chat WhatsApp"><i class="fab fa-whatsapp"></i></button>

  <div class="search-overlay" id="searchOverlay">
    <div class="search-box">
      <div class="search-top">
        <h3>Cari Produk {{ $siteName }}</h3>
        <button class="close-search" onclick="closeSearch()" aria-label="Tutup pencarian"><i class="fas fa-times"></i></button>
      </div>
      <label class="overlay-field" for="overlaySearchInput">
        <i class="fas fa-search"></i>
        <input id="overlaySearchInput" type="search" placeholder="Contoh: 12oz, oval, square, lid..." oninput="renderOverlaySearch(this.value)">
      </label>
      <div class="overlay-results" id="overlayResults"></div>
      <div class="search-hint">Tekan Ctrl + K untuk membuka pencarian cepat, Esc untuk menutup.</div>
    </div>
  </div>

  <div class="modal" id="productModal" onclick="closeModalBackdrop(event)">
    <div class="modal-box">
      <button class="modal-close" onclick="closeModal()"><i class="fas fa-times"></i></button>
      <div class="modal-content">
        <div class="modal-img"><img id="modalImg" alt="Detail produk"></div>
        <div class="modal-info">
          <div class="modal-cat" id="modalCat">Kategori</div>
          <h3 class="modal-title" id="modalTitle">Nama Produk</h3>
          <p class="modal-desc" id="modalDesc">Deskripsi produk</p>
          <div class="detail-table" id="modalSpecs"></div>
          <div class="modal-actions">
            <button class="btn btn-primary" id="modalWa"><i class="fab fa-whatsapp"></i> Tanya Produk Ini</button>
            <button class="btn btn-light" onclick="closeModal()"><i class="fas fa-arrow-left"></i> Kembali</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal partnership-modal" id="partnershipModal" onclick="closePartnershipBackdrop(event)">
    <div class="modal-box partnership-box">
      <button class="modal-close" onclick="closePartnershipForm()" aria-label="Tutup form mitra"><i class="fas fa-times"></i></button>
      <div class="partnership-content">
        <div class="partnership-copy">
          <span class="modal-cat"><i class="fas fa-handshake"></i> Kemitraan</span>
          <h3 class="modal-title">Jadi Mitra HokCup</h3>
          <p class="modal-desc">Isi data singkat berikut agar tim kami bisa menghubungi Anda untuk kebutuhan reseller, outlet, distributor, atau pembelian rutin.</p>
          <div class="partner-benefits">
            <span><i class="fas fa-check"></i> Konsultasi kebutuhan produk</span>
            <span><i class="fas fa-check"></i> Harga untuk pembelian rutin</span>
            <span><i class="fas fa-check"></i> Cocok untuk outlet, reseller, dan event</span>
          </div>
        </div>
        <form class="partnership-form" action="{{ route('partnership.store') }}" method="POST" onsubmit="submitPartnershipForm(event)">
          @csrf
          <input type="hidden" name="source_url" value="{{ request()->fullUrl() }}">
          <div class="form-grid">
            <label>Nama Lengkap
              <input name="name" type="text" placeholder="Nama Anda" required>
            </label>
            <label>Nama Usaha / Brand
              <input name="business" type="text" placeholder="Contoh: Kedai Kopi Rasa" required>
            </label>
            <label>Nomor WhatsApp
              <input name="phone" type="tel" placeholder="08xxxxxxxxxx" required>
            </label>
            <label>Kota / Domisili
              <input name="city" type="text" placeholder="Contoh: Surabaya" required>
            </label>
            <label>Jenis Mitra
              <select name="type" required>
                <option value="">Pilih jenis mitra</option>
                <option value="Reseller">Reseller</option>
                <option value="Outlet minuman / F&B">Outlet minuman / F&B</option>
                <option value="Distributor">Distributor</option>
                <option value="Event / catering">Event / catering</option>
                <option value="Lainnya">Lainnya</option>
              </select>
            </label>
            <label>Estimasi Kebutuhan
              <select name="need" required>
                <option value="">Pilih estimasi</option>
                <option value="Kurang dari 1 karton / bulan">Kurang dari 1 karton / bulan</option>
                <option value="1-5 karton / bulan">1-5 karton / bulan</option>
                <option value="6-20 karton / bulan">6-20 karton / bulan</option>
                <option value="Lebih dari 20 karton / bulan">Lebih dari 20 karton / bulan</option>
              </select>
            </label>
          </div>
          <label>Catatan Kebutuhan Produk
            <textarea name="message" rows="4" placeholder="Contoh: butuh cup 12oz, lid, atau printing custom"></textarea>
          </label>
          <button class="btn btn-primary partner-submit" type="submit"><i class="fab fa-whatsapp"></i> Simpan & Kirim ke WhatsApp</button>
        </form>
      </div>
    </div>
  </div>

  <script>
    const LOGO = @json($siteSetting?->logo_url ?? '');
    const WA_REDIRECT_URL = @json(route('whatsapp.redirect'));
    const SITE_NAME = @json($siteName);
    const categories = @json($frontendCategories);
    const products = @json($frontendProducts);
    const PARTNERSHIP_CATEGORY_ID = 'grosir';

    let currentCategory = 'all';
    let currentPage = 1;
    const productsPerPage = 6;

    function isPartnershipCategory(id){
      return id === PARTNERSHIP_CATEGORY_ID;
    }
    function getCategoryName(id){
      if(isPartnershipCategory(id)) return 'Jadi Mitra HokCup';
      const cat = categories.find(c => c.id === id);
      return cat ? cat.name : 'Kategori';
    }
    function getCategoryShort(id){
      if(isPartnershipCategory(id)) return 'Mitra';
      const cat = categories.find(c => c.id === id);
      return cat ? cat.short : 'Produk';
    }
    function getCategoryDesc(cat){
      if(isPartnershipCategory(cat.id)) return 'Daftar reseller/outlet';
      return cat.desc;
    }
    function catalogProducts(){
      return products.filter(p => !isPartnershipCategory(p.category));
    }
    function countByCat(id){
      if(id === 'all') return catalogProducts().length;
      if(isPartnershipCategory(id)) return 0;
      return catalogProducts().filter(p => p.category === id).length;
    }
    function setCategory(id){
      currentCategory = id;
      currentPage = 1;
      renderCategories();
      renderFilters();
      renderProducts();
      closeMobileMenu();
    }
    function renderCategories(){
      const wrap = document.getElementById('categoryTiles');
      wrap.innerHTML = categories.filter(c => c.id !== 'all').map(cat => {
        const isPartner = isPartnershipCategory(cat.id);
        const clickAction = isPartner
          ? `openPartnershipForm()`
          : `setCategory('${cat.id}'); document.getElementById('produk').scrollIntoView({behavior:'smooth'});`;
        const summary = isPartner
          ? `${getCategoryDesc(cat)}<br><strong>Isi form kemitraan</strong>`
          : `${getCategoryDesc(cat)}<br><strong>${countByCat(cat.id)} produk</strong>`;
        return `
          <div class="cat-tile ${isPartner ? 'partner-tile' : ''} ${currentCategory === cat.id && !isPartner ? 'active' : ''}" onclick="${clickAction}">
            <div class="cat-icon"><i class="fas ${isPartner ? 'fa-handshake' : cat.icon}"></i></div>
            <h3>${getCategoryName(cat.id)}</h3>
            <p>${summary}</p>
          </div>
        `;
      }).join('');
    }
    function renderFilters(){
      const list = document.getElementById('filterList');
      list.innerHTML = categories.map(cat => {
        const isPartner = isPartnershipCategory(cat.id);
        const clickAction = isPartner ? 'openPartnershipForm()' : `setCategory('${cat.id}')`;
        return `
          <button class="filter-btn ${currentCategory === cat.id && !isPartner ? 'active' : ''}" onclick="${clickAction}">
            <span>${getCategoryName(cat.id)}</span><span>${isPartner ? 'Form' : countByCat(cat.id)}</span>
          </button>
        `;
      }).join('');
    }
    function renderPagination(totalItems){
      const totalPages = Math.ceil(totalItems / productsPerPage);
      const pagination = document.getElementById('pagination');
      if(totalPages <= 1){ pagination.innerHTML = ''; return; }
      const pages = Array.from({length: totalPages}, (_, i) => i + 1).map(page =>
        `<button class="page-btn ${page === currentPage ? 'active' : ''}" onclick="goToPage(${page})">${page}</button>`
      ).join('');
      pagination.innerHTML = `
        <button class="page-btn" ${currentPage === 1 ? 'disabled' : ''} onclick="goToPage(${currentPage - 1})"><i class="fas fa-chevron-left"></i></button>
        <span class="page-summary">Halaman ${currentPage} / ${totalPages}</span>
        ${pages}
        <button class="page-btn" ${currentPage === totalPages ? 'disabled' : ''} onclick="goToPage(${currentPage + 1})"><i class="fas fa-chevron-right"></i></button>
      `;
    }
    function goToPage(page){
      currentPage = page;
      renderProducts(false);
      document.getElementById('produk').scrollIntoView({behavior:'smooth', block:'start'});
    }
    function renderProducts(resetPage = true){
      if(resetPage) currentPage = 1;
      const q = document.getElementById('searchInput').value.trim().toLowerCase();
      const sort = document.getElementById('sortSelect').value;
      let data = catalogProducts().filter(p => {
        const byCat = currentCategory === 'all' || p.category === currentCategory;
        const haystack = `${p.name} ${getCategoryName(p.category)} ${p.desc} ${Object.values(p.specs).join(' ')}`.toLowerCase();
        return byCat && (!q || haystack.includes(q));
      });
      if(sort === 'name') data.sort((a,b) => a.name.localeCompare(b.name));
      if(sort === 'size') data.sort((a,b) => (a.size || 999) - (b.size || 999));
      const grid = document.getElementById('productGrid');
      const empty = document.getElementById('emptyState');
      const resultTitle = document.getElementById('resultTitle');
      const resultCount = document.getElementById('resultCount');
      const totalPages = Math.max(1, Math.ceil(data.length / productsPerPage));
      currentPage = Math.min(currentPage, totalPages);
      const start = (currentPage - 1) * productsPerPage;
      const pageItems = data.slice(start, start + productsPerPage);
      resultTitle.textContent = currentCategory === 'all' ? 'Semua Produk' : getCategoryName(currentCategory);
      const from = data.length ? start + 1 : 0;
      const to = Math.min(start + pageItems.length, data.length);
      resultCount.textContent = q ? `${from}-${to} dari ${data.length} hasil untuk “${q}”` : `${from}-${to} dari ${data.length} produk tersedia`;
      if(!data.length){
        grid.innerHTML = '';
        document.getElementById('pagination').innerHTML = '';
        empty.style.display = 'block';
        return;
      }
      empty.style.display = 'none';
      grid.innerHTML = pageItems.map(p => `
        <article class="product-card" onclick="openProduct(${p.id})">
          <div class="product-img">
            <img src="${p.image}" alt="${p.name}" loading="lazy">
            <div class="badge">${p.label}</div>
            <div class="tag-red">${getCategoryShort(p.category)}</div>
          </div>
          <div class="product-body">
            <div class="product-cat">${getCategoryName(p.category)}</div>
            <h3 class="product-name">${p.name}</h3>
            <p class="product-desc">${p.desc}</p>
            <div class="specs">
              ${Object.entries(p.specs).slice(0,3).map(([k,v]) => `<span>${v}</span>`).join('')}
            </div>
            <div class="card-actions">
              <button class="detail-btn" onclick="event.stopPropagation();openProduct(${p.id})">Lihat Detail</button>
              <button class="wa-mini" onclick="event.stopPropagation();openWa('${encodeURIComponent(p.name)}')"><i class="fab fa-whatsapp"></i></button>
            </div>
          </div>
        </article>
      `).join('');
      renderPagination(data.length);
    }
    function openProduct(id){
      const p = products.find(item => item.id === id);
      if(!p) return;
      document.getElementById('modalImg').src = p.image;
      document.getElementById('modalImg').alt = p.name;
      document.getElementById('modalCat').textContent = getCategoryName(p.category);
      document.getElementById('modalTitle').textContent = p.name;
      document.getElementById('modalDesc').textContent = p.desc;
      document.getElementById('modalSpecs').innerHTML = Object.entries(p.specs).map(([k,v]) => `
        <div class="detail-row"><strong>${k}</strong><span>${v}</span></div>
      `).join('');
      document.getElementById('modalWa').onclick = () => openWa(encodeURIComponent(p.name));
      document.getElementById('productModal').classList.add('open');
      document.body.style.overflow = 'hidden';
    }
    function openSearch(){
      const overlay = document.getElementById('searchOverlay');
      overlay.classList.add('open');
      document.body.style.overflow = 'hidden';
      setTimeout(() => document.getElementById('overlaySearchInput').focus(), 80);
      renderOverlaySearch(document.getElementById('overlaySearchInput').value || '');
    }
    function closeSearch(){
      document.getElementById('searchOverlay').classList.remove('open');
      document.body.style.overflow = '';
    }
    function renderOverlaySearch(value){
      const q = (value || '').trim().toLowerCase();
      const list = catalogProducts().filter(p => {
        const text = `${p.name} ${getCategoryName(p.category)} ${p.label} ${p.desc} ${p.size ? p.size + 'oz' : ''} ${Object.values(p.specs).join(' ')}`.toLowerCase();
        return !q || text.includes(q);
      }).slice(0, 10);
      const results = document.getElementById('overlayResults');
      if(!list.length){
        results.innerHTML = `
          <div class="overlay-empty">
            <i class="far fa-frown"></i>
            <strong>Tidak ada hasil</strong><br>
            <span>Coba kata kunci lain seperti 12oz, oval, square, atau lid.</span>
          </div>
        `;
        return;
      }
      results.innerHTML = list.map(p => {
        const sizeLabel = p.size ? `${p.size} oz` : (p.specs.Ukuran || p.specs.Paket || 'Custom');
        return `
          <div class="overlay-item" onclick="closeSearch();openProduct(${p.id})">
            <img src="${p.image}" alt="${p.name}" loading="lazy">
            <div>
              <small>${getCategoryName(p.category)}</small>
              <strong>${p.name}</strong>
              <span>${sizeLabel} · ${p.desc}</span>
            </div>
            <i class="fas fa-arrow-right"></i>
          </div>
        `;
      }).join('');
    }
    function closeModal(){
      document.getElementById('productModal').classList.remove('open');
      document.body.style.overflow = '';
    }
    function closeModalBackdrop(e){
      if(e.target.id === 'productModal') closeModal();
    }
    function buildWaUrl(text, productName = ''){
      const url = new URL(WA_REDIRECT_URL, window.location.origin);
      url.searchParams.set('text', text);
      if(productName) url.searchParams.set('product', productName);
      return url.toString();
    }
    function openWa(productName){
      const decodedProduct = decodeURIComponent(productName || '');
      const text = `Halo ${SITE_NAME}, saya ingin bertanya tentang produk ${decodedProduct}.`;
      window.open(buildWaUrl(text, decodedProduct), '_blank');
    }
    function openWaGeneral(){
      const text = `Halo ${SITE_NAME}, saya ingin bertanya produk dan katalog harga.`;
      window.open(buildWaUrl(text), '_blank');
    }

    function openPartnershipForm(){
      closeMobileMenu();
      const modal = document.getElementById('partnershipModal');
      modal.classList.add('open');
      document.body.style.overflow = 'hidden';
    }
    function closePartnershipForm(){
      document.getElementById('partnershipModal').classList.remove('open');
      document.body.style.overflow = '';
    }
    function closePartnershipBackdrop(e){
      if(e.target.id === 'partnershipModal') closePartnershipForm();
    }
    async function submitPartnershipForm(e){
      e.preventDefault();
      const form = e.currentTarget;
      const submitBtn = form.querySelector('.partner-submit');
      const formData = new FormData(form);
      const data = Object.fromEntries(formData.entries());
      const text = [
        `Halo ${SITE_NAME}, saya ingin menjadi Mitra HokCup.`,
        '',
        `Nama: ${data.name || '-'}`,
        `Nama Usaha/Brand: ${data.business || '-'}`,
        `No. WhatsApp: ${data.phone || '-'}`,
        `Kota/Domisili: ${data.city || '-'}`,
        `Jenis Mitra: ${data.type || '-'}`,
        `Estimasi Kebutuhan: ${data.need || '-'}`,
        `Catatan: ${data.message || '-'}`,
      ].join('\n');

      const whatsappTab = window.open('', '_blank');
      submitBtn.disabled = true;
      submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';

      try {
        const response = await fetch(form.action, {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
          },
          body: formData,
        });

        if(!response.ok){
          throw new Error('Gagal menyimpan data mitra.');
        }

        if(whatsappTab){
          whatsappTab.location.href = buildWaUrl(text);
        } else {
          window.open(buildWaUrl(text), '_blank');
        }

        closePartnershipForm();
        form.reset();
      } catch (error) {
        if(whatsappTab) whatsappTab.close();
        alert('Maaf, data mitra belum berhasil tersimpan. Silakan coba lagi.');
      } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="fab fa-whatsapp"></i> Simpan & Kirim ke WhatsApp';
      }
    }
    function toggleMobileMenu(){document.getElementById('mobileMenu').classList.toggle('open')}
    function closeMobileMenu(){document.getElementById('mobileMenu').classList.remove('open')}
    document.addEventListener('keydown', e => {
      if(e.key === 'Escape'){ closeSearch(); closeModal(); closePartnershipForm(); closeMobileMenu(); }
      if((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k'){ e.preventDefault(); openSearch(); }
    });
    document.getElementById('searchOverlay').addEventListener('click', e => { if(e.target.id === 'searchOverlay') closeSearch(); });
    renderCategories();
    renderFilters();
    renderProducts();
  </script>
  {!! $siteSetting?->body_end_scripts !!}
</body>
</html>
