@extends('admin.layout')
@section('title','SEO Settings')
@section('page_title','SEO Settings')
@section('page_description','Kelola meta tag, Open Graph, Twitter Card, canonical URL, robots, dan schema JSON-LD untuk frontend.')
@section('content')
<form class="card" method="POST" action="{{ route('admin.seo.update') }}" enctype="multipart/form-data">
  @csrf
  @method('PUT')

  <div class="section-note">
    Isi SEO utama agar halaman lebih rapi saat tampil di Google dan ketika link dibagikan ke WhatsApp/Facebook. Untuk kata kunci, gunakan seperlunya dan utamakan judul serta deskripsi yang natural.
  </div>

  <div class="admin-divider"></div>

  <div class="grid grid-2">
    <div class="field">
      <label>Meta Title</label>
      <input name="meta_title" value="{{ old('meta_title', $setting->meta_title) }}" maxlength="180" placeholder="Hok Cup - Gelas Plastik Food Grade">
      <div class="help">Disarankan 50–60 karakter.</div>
    </div>

    <div class="field">
      <label>Robots</label>
      <select name="seo_robots">
        @foreach(['index, follow','noindex, follow','index, nofollow','noindex, nofollow'] as $robots)
          <option value="{{ $robots }}" {{ old('seo_robots', $setting->seo_robots ?: 'index, follow') === $robots ? 'selected' : '' }}>{{ $robots }}</option>
        @endforeach
      </select>
      <div class="help">Gunakan <code>index, follow</code> untuk website publik.</div>
    </div>
  </div>

  <br>

  <div class="field">
    <label>Meta Description</label>
    <textarea name="meta_description" maxlength="500" placeholder="Deskripsi singkat halaman untuk hasil pencarian Google.">{{ old('meta_description', $setting->meta_description) }}</textarea>
    <div class="help">Disarankan 140–160 karakter.</div>
  </div>

  <br>

  <div class="field">
    <label>Meta Keywords</label>
    <textarea name="meta_keywords" maxlength="500" placeholder="Hok Cup, gelas plastik, cup plastik, food grade">{{ old('meta_keywords', $setting->meta_keywords) }}</textarea>
  </div>

  <br>

  <div class="field">
    <label>Canonical URL</label>
    <input name="canonical_url" value="{{ old('canonical_url', $setting->canonical_url) }}" placeholder="https://domainanda.com/">
  </div>

  <div class="admin-divider"></div>

  <h3>Open Graph / Share Preview</h3>
  <div class="grid grid-2">
    <div class="field">
      <label>OG Image URL</label>
      <input name="og_image" value="{{ old('og_image', $setting->og_image) }}" placeholder="https://.../image.jpg">
      <div class="help">Gambar preview saat link dibagikan.</div>
    </div>

    <div class="field">
      <label>Upload OG Image</label>
      <input type="file" name="og_image_file" accept="image/*">
      @if($setting->og_image_url)
        <div class="help">
          <img class="preview" src="{{ $setting->og_image_url }}" alt="OG Image Preview">
        </div>
      @endif
    </div>
  </div>

  <div class="admin-divider"></div>

  <h3>Twitter Card</h3>
  <div class="grid grid-2">
    <div class="field">
      <label>Twitter Title</label>
      <input name="twitter_title" value="{{ old('twitter_title', $setting->twitter_title) }}" placeholder="Kosongkan jika sama dengan Meta Title">
    </div>

    <div class="field">
      <label>Twitter Image URL</label>
      <input name="twitter_image" value="{{ old('twitter_image', $setting->twitter_image) }}" placeholder="Kosongkan jika sama dengan OG Image">
    </div>

    <div class="field">
      <label>Twitter Description</label>
      <textarea name="twitter_description" placeholder="Kosongkan jika sama dengan Meta Description">{{ old('twitter_description', $setting->twitter_description) }}</textarea>
    </div>

    <div class="field">
      <label>Upload Twitter Image</label>
      <input type="file" name="twitter_image_file" accept="image/*">
      @if($setting->twitter_image_url)
        <div class="help">
          <img class="preview" src="{{ $setting->twitter_image_url }}" alt="Twitter Image Preview">
        </div>
      @endif
    </div>
  </div>

  <div class="admin-divider"></div>

  <div class="field">
    <label>Schema JSON-LD</label>
    <textarea name="schema_json_ld" style="min-height:220px" placeholder="Contoh: Organization, LocalBusiness, Product, atau WebSite schema dalam format JSON valid.">{{ old('schema_json_ld', $setting->schema_json_ld) }}</textarea>
    <div class="help">Opsional. Harus format JSON valid. Sistem otomatis membungkusnya dalam script <code>application/ld+json</code>.</div>
  </div>

  <br>

  <button class="btn btn-primary"><i class="fas fa-save"></i> Simpan SEO</button>
</form>
@endsection
