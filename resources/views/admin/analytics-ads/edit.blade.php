@extends('admin.layout')
@section('title','Tracking & Ads')
@section('page_title','Tracking & Ads')
@section('page_description','Pasang Google Analytics, GTM, Meta Pixel, Google Ads, dan script tracking tambahan tanpa edit kode.')
@section('content')
<form class="card" method="POST" action="{{ route('admin.analytics-ads.update') }}">
  @csrf @method('PUT')
  <div class="section-note">
    Isi ID tracking saja jika tersedia. Untuk script khusus dari platform iklan lain, gunakan area script custom di bawah. Script akan otomatis dimasukkan ke frontend.
  </div>
  <br>
  <div class="grid grid-2">
    <div class="field">
      <label>Google Analytics Measurement ID</label>
      <input name="google_analytics_id" value="{{ old('google_analytics_id',$setting->google_analytics_id) }}" placeholder="G-XXXXXXXXXX">
      <div class="help">Contoh: <code>G-ABC123XYZ</code></div>
    </div>
    <div class="field">
      <label>Google Tag Manager ID</label>
      <input name="google_tag_manager_id" value="{{ old('google_tag_manager_id',$setting->google_tag_manager_id) }}" placeholder="GTM-XXXXXXX">
      <div class="help">Contoh: <code>GTM-ABC1234</code></div>
    </div>
    <div class="field">
      <label>Meta Pixel ID</label>
      <input name="meta_pixel_id" value="{{ old('meta_pixel_id',$setting->meta_pixel_id) }}" placeholder="123456789012345">
      <div class="help">Untuk iklan Facebook/Instagram via Meta Pixel.</div>
    </div>
    <div class="field">
      <label>Google Ads ID</label>
      <input name="google_ads_id" value="{{ old('google_ads_id',$setting->google_ads_id) }}" placeholder="AW-XXXXXXXXX">
      <div class="help">Contoh: <code>AW-123456789</code></div>
    </div>
    <div class="field">
      <label>Google Ads Conversion Label</label>
      <input name="google_ads_conversion_label" value="{{ old('google_ads_conversion_label',$setting->google_ads_conversion_label) }}" placeholder="AbCdEfGhIjKlMnOpQrSt">
      <div class="help">Opsional. Disimpan untuk kebutuhan event conversion.</div>
    </div>
  </div>

  <div class="admin-divider"></div>

  <div class="grid grid-3">
    <div class="field">
      <label>Custom Script di &lt;head&gt;</label>
      <textarea name="head_scripts" style="min-height:190px" placeholder="Paste script tambahan di sini">{{ old('head_scripts',$setting->head_scripts) }}</textarea>
    </div>
    <div class="field">
      <label>Custom Script setelah &lt;body&gt;</label>
      <textarea name="body_start_scripts" style="min-height:190px" placeholder="Contoh noscript GTM atau tracking body">{{ old('body_start_scripts',$setting->body_start_scripts) }}</textarea>
    </div>
    <div class="field">
      <label>Custom Script sebelum &lt;/body&gt;</label>
      <textarea name="body_end_scripts" style="min-height:190px" placeholder="Script chat/ads tambahan">{{ old('body_end_scripts',$setting->body_end_scripts) }}</textarea>
    </div>
  </div>
  <br>
  <button class="btn btn-primary"><i class="fas fa-save"></i> Simpan Analytics & Ads</button>
</form>
@endsection
