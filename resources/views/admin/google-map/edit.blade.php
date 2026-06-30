@extends('admin.layout')
@section('title','Google Maps')
@section('page_title','Google Maps')
@section('page_description','Kelola section lokasi dan embed Google Maps yang tampil di frontend.')
@section('content')
<form class="card" method="POST" action="{{ route('admin.google-map.update') }}">
  @csrf @method('PUT')
  <div class="grid grid-2">
    <div class="field"><label>Eyebrow Icon</label><input name="eyebrow_icon" value="{{ old('eyebrow_icon',$map->eyebrow_icon ?: 'fa-location-dot') }}"><div class="help">Gunakan class Font Awesome tanpa prefix <code>fas</code>.</div></div>
    <div class="field"><label>Eyebrow Text</label><input name="eyebrow_text" value="{{ old('eyebrow_text',$map->eyebrow_text) }}"></div>
    <div class="field"><label>Judul Section</label><input name="title" value="{{ old('title',$map->title) }}" required></div>
    <div class="field"><label>Teks Tombol</label><input name="button_text" value="{{ old('button_text',$map->button_text) }}" placeholder="Buka Google Maps"></div>
    <div class="field"><label>URL Tombol Google Maps</label><input name="button_url" value="{{ old('button_url',$map->button_url) }}" placeholder="https://maps.app.goo.gl/... atau link directions"></div>
  </div><br>
  <div class="field"><label>Deskripsi</label><textarea name="description">{{ old('description',$map->description) }}</textarea></div><br>
  <div class="field"><label>Alamat</label><textarea name="address">{{ old('address',$map->address) }}</textarea></div><br>
  <div class="field"><label>Embed Google Maps</label><textarea name="embed_code" style="min-height:190px" placeholder="Paste kode iframe Google Maps di sini">{{ old('embed_code',$map->embed_code) }}</textarea><div class="help">Dari Google Maps: Share → Embed a map → Copy HTML.</div></div><br>
  <label style="display:flex;gap:8px;align-items:center;font-weight:900"><input type="checkbox" name="is_active" value="1" @checked(old('is_active',$map->is_active ?? true))> Tampilkan section Google Maps di frontend</label><br>
  <button class="btn btn-primary"><i class="fas fa-save"></i> Simpan Google Maps</button>
</form>
@endsection
