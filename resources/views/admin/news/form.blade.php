@extends('admin.layout')
@section('title', $mode === 'create' ? 'Tambah News' : 'Edit News')
@section('page_title', $mode === 'create' ? 'Tambah News' : 'Edit News')
@section('page_description','Isi artikel atau berita yang akan tampil di section News frontend.')
@section('content')
<form class="card" method="POST" enctype="multipart/form-data" action="{{ $mode === 'create' ? route('admin.news.store') : route('admin.news.update',$article) }}">
  @csrf @if($mode==='edit')@method('PUT')@endif

  <div class="grid grid-2">
    <div class="field"><label>Judul *</label><input name="title" value="{{ old('title',$article->title) }}" placeholder="Contoh: Tips Memilih Gelas Plastik untuk Bisnis Minuman" required></div>
    <div class="field"><label>Slug</label><input name="slug" value="{{ old('slug',$article->slug) }}" placeholder="otomatis jika dikosongkan"><div class="help">Digunakan untuk URL detail news.</div></div>
    <div class="field"><label>Author</label><input name="author" value="{{ old('author',$article->author) }}" placeholder="Admin"></div>
    <div class="field"><label>Tanggal Publish</label><input type="datetime-local" name="published_at" value="{{ old('published_at', optional($article->published_at)->format('Y-m-d\TH:i')) }}"></div>
    <div class="field"><label>Image URL</label><input name="image" value="{{ old('image',$article->image) }}" placeholder="https://..."></div>
    <div class="field"><label>Upload Image</label><input type="file" name="image_file" accept="image/*"><div class="help">Kosongkan jika ingin memakai Image URL / gambar lama.</div></div>
    <div class="field"><label>Urutan</label><input type="number" name="sort_order" value="{{ old('sort_order',$article->sort_order ?? 0) }}"></div>
  </div>

  @if($article->image_url)
    <br><img src="{{ $article->image_url }}" alt="Preview" style="width:180px;height:110px;object-fit:cover;border-radius:18px;border:1px solid var(--line)">
  @endif

  <br><br>
  <div class="field"><label>Ringkasan / Excerpt</label><textarea name="excerpt" rows="4" placeholder="Ringkasan singkat yang tampil di kartu news">{{ old('excerpt',$article->excerpt) }}</textarea></div>
  <br>
  <div class="field"><label>Konten</label><textarea name="content" rows="12" placeholder="Isi artikel lengkap. Boleh menggunakan tag HTML sederhana seperti <p>, <br>, <strong>, <ul>, <li>.">{{ old('content',$article->content) }}</textarea></div>
  <br>
  <div class="form-check-row">
    <label><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured',$article->is_featured ?? false))> Featured</label>
    <label><input type="checkbox" name="is_active" value="1" @checked(old('is_active',$article->is_active ?? true))> Aktif</label>
  </div>
  <br>
  <button class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
  <a class="btn btn-light" href="{{ route('admin.news.index') }}">Kembali</a>
</form>
@endsection
