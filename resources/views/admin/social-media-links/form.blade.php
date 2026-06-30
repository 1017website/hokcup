@extends('admin.layout')
@section('title', $mode === 'create' ? 'Tambah Sosial Media' : 'Edit Sosial Media')
@section('page_title', $mode === 'create' ? 'Tambah Sosial Media' : 'Edit Sosial Media')
@section('page_description','Atur platform sosial media yang akan tampil sebagai kartu link di halaman depan.')
@section('content')
<form class="card" method="POST" action="{{ $mode === 'create' ? route('admin.social-media-links.store') : route('admin.social-media-links.update',$link) }}">
  @csrf @if($mode==='edit')@method('PUT')@endif
  <div class="grid grid-2">
    <div class="field"><label>Platform</label><input name="platform" value="{{ old('platform',$link->platform) }}" placeholder="Instagram" required></div>
    <div class="field"><label>Label Tombol</label><input name="label" value="{{ old('label',$link->label) }}" placeholder="Follow Instagram"></div>
    <div class="field"><label>Icon Class</label><input name="icon" value="{{ old('icon',$link->icon ?: 'fab fa-instagram') }}" required><div class="help">Contoh: <code>fab fa-instagram</code>, <code>fab fa-tiktok</code>, <code>fab fa-facebook</code>.</div></div>
    <div class="field"><label>Username / Handle</label><input name="username" value="{{ old('username',$link->username) }}" placeholder="@hokcup"></div>
    <div class="field"><label>URL</label><input name="url" value="{{ old('url',$link->url) }}" placeholder="https://instagram.com/..." required></div>
    <div class="field"><label>Urutan</label><input type="number" name="sort_order" value="{{ old('sort_order',$link->sort_order ?? 0) }}"></div>
  </div><br>
  <div class="field"><label>Deskripsi</label><textarea name="description">{{ old('description',$link->description) }}</textarea></div><br>
  <label style="display:flex;gap:8px;align-items:center;font-weight:900"><input type="checkbox" name="is_active" value="1" @checked(old('is_active',$link->is_active ?? true))> Aktif</label><br>
  <button class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button> <a class="btn btn-light" href="{{ route('admin.social-media-links.index') }}">Kembali</a>
</form>
@endsection
