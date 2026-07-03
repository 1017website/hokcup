@extends('admin.layout')
@section('title','Site Setting & WhatsApp')
@section('page_title','Site Setting & WhatsApp')
@section('page_description','Kelola identitas brand, nomor WhatsApp fallback, email, jam operasional, dan logo website.')
@section('page_action')
  <a class="btn btn-light" href="{{ route('admin.seo.edit') }}"><i class="fas fa-magnifying-glass-chart"></i> Atur SEO</a>
@endsection
@section('content')
<form class="card" method="POST" action="{{ route('admin.site-settings.update') }}" enctype="multipart/form-data">
  @csrf @method('PUT')

  <div class="section-note">
    <strong>Nomor WhatsApp utama sekarang ada di menu CS WhatsApp.</strong><br>
    Kolom <b>Nomor WhatsApp</b> di halaman ini menjadi nomor fallback jika semua CS nonaktif. Untuk membuat beberapa CS dan membagi leads secara merata, buka menu <b>CS WhatsApp</b>.
  </div>

  <div class="admin-divider"></div>

  <div class="grid grid-2">
    <div class="field"><label>Nama Website</label><input name="site_name" value="{{ old('site_name',$setting->site_name) }}" required></div>
    <div class="field"><label>Tagline Brand</label><input name="brand_tagline" value="{{ old('brand_tagline',$setting->brand_tagline) }}" placeholder="Food Grade Packaging"></div>
    <div class="field">
      <label>Nomor WhatsApp Fallback</label>
      <input name="whatsapp_number" value="{{ old('whatsapp_number',$setting->whatsapp_number) }}" required placeholder="6281234567890">
      <div class="help">Dipakai hanya jika semua CS WhatsApp nonaktif. Format: <code>62</code> + nomor HP. Jangan pakai <code>+</code>, spasi, atau tanda hubung.</div>
    </div>
    <div class="field"><label>Email</label><input type="email" name="email" value="{{ old('email',$setting->email) }}" placeholder="sales@hokcup.co.id"></div>
    <div class="field"><label>Jam Operasional</label><input name="operational_hours" value="{{ old('operational_hours',$setting->operational_hours) }}" placeholder="Senin–Sabtu 08.00–17.00"></div>
    <div class="field"><label>Logo URL</label><input name="logo" value="{{ old('logo',$setting->logo) }}"><div class="help">Bisa URL eksternal atau upload file di bawah. Logo ini dipakai di frontend dan sidebar CMS.</div></div>
    <div class="field"><label>Upload Logo</label><input type="file" name="logo_file" accept="image/*">@if($setting->logo_url)<div class="help"><img class="preview" src="{{ $setting->logo_url }}"></div>@endif</div>
    <div class="field"><label>Favicon URL</label><input name="favicon" value="{{ old('favicon',$setting->favicon) }}" placeholder="https://domain.com/favicon.png"><div class="help">Favicon tampil di tab browser untuk frontend, CMS admin, login CMS, News, Karir, dan halaman detail.</div></div>
    <div class="field"><label>Upload Favicon</label><input type="file" name="favicon_file" accept="image/*,.ico">@if($setting->favicon_url)<div class="help"><img class="preview preview-favicon" src="{{ $setting->favicon_url }}"></div>@endif</div>
  </div>

  <div class="admin-divider"></div>

  <div class="grid grid-2">
    <div class="card-mini">
      <i class="fab fa-whatsapp"></i>
      <div>
        <strong>Preview nomor fallback</strong>
        <span>https://wa.me/{{ old('whatsapp_number',$setting->whatsapp_number ?: '6281234567890') }}</span>
      </div>
    </div>
    <div class="card-mini">
      <i class="fas fa-magnifying-glass-chart"></i>
      <div>
        <strong>SEO dipindah ke menu khusus</strong>
        <span>Meta title, description, OG image, robots, canonical, dan schema JSON-LD ada di menu SEO.</span>
      </div>
    </div>
  </div>

  <br>
  <div class="actions"><button class="btn btn-primary"><i class="fas fa-save"></i> Simpan Setting</button><a class="btn btn-light" href="{{ route('admin.whatsapp-cs.index') }}"><i class="fab fa-whatsapp"></i> Kelola CS WhatsApp</a></div>
</form>
@endsection
