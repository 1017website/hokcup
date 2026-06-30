@extends('admin.layout')
@section('title', $mode === 'create' ? 'Tambah Kategori' : 'Edit Kategori')
@section('page_title', $mode === 'create' ? 'Tambah Kategori' : 'Edit Kategori')
@section('page_description','Gunakan icon Font Awesome tanpa class fas, contoh: fa-cup-straw.')
@section('content')
<form class="card" method="POST" action="{{ $mode === 'create' ? route('admin.categories.store') : route('admin.categories.update',$category) }}">@csrf @if($mode==='edit')@method('PUT')@endif
  <div class="grid grid-2">
    <div class="field"><label>Nama</label><input name="name" value="{{ old('name',$category->name) }}" required></div>
    <div class="field"><label>Slug</label><input name="slug" value="{{ old('slug',$category->slug) }}"><div class="help">Kosongkan agar otomatis.</div></div>
    <div class="field"><label>Short Name</label><input name="short_name" value="{{ old('short_name',$category->short_name) }}" required></div>
    <div class="field"><label>Icon</label><input name="icon" value="{{ old('icon',$category->icon ?: 'fa-cup-straw') }}" required></div>
    <div class="field"><label>Urutan</label><input type="number" name="sort_order" value="{{ old('sort_order',$category->sort_order ?? 0) }}"></div>
    <label style="align-self:end"><input type="checkbox" name="is_active" value="1" @checked(old('is_active',$category->is_active ?? true))> Aktif</label>
  </div><br>
  <div class="field"><label>Deskripsi Singkat</label><textarea name="description">{{ old('description',$category->description) }}</textarea></div><br>
  <button class="btn btn-primary">Simpan</button> <a class="btn btn-light" href="{{ route('admin.categories.index') }}">Kembali</a>
</form>
@endsection
