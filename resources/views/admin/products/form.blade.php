@extends('admin.layout')
@section('title', $mode === 'create' ? 'Tambah Produk' : 'Edit Produk')
@section('page_title', $mode === 'create' ? 'Tambah Produk' : 'Edit Produk')
@section('page_description','Spesifikasi akan tampil di card dan modal detail produk.')
@section('content')
<form class="card" method="POST" action="{{ $mode === 'create' ? route('admin.products.store') : route('admin.products.update',$product) }}" enctype="multipart/form-data">@csrf @if($mode==='edit')@method('PUT')@endif
  <div class="grid grid-2">
    <div class="field"><label>Kategori</label><select name="category_id" required><option value="">Pilih kategori</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id',$product->category_id)==$category->id)>{{ $category->name }}</option>@endforeach</select></div>
    <div class="field"><label>Nama Produk</label><input name="name" value="{{ old('name',$product->name) }}" required></div>
    <div class="field"><label>Slug</label><input name="slug" value="{{ old('slug',$product->slug) }}"><div class="help">Kosongkan agar otomatis.</div></div>
    <div class="field"><label>Ukuran oz</label><input type="number" name="size" value="{{ old('size',$product->size ?? 0) }}"><div class="help">Isi 0 untuk custom / aksesoris.</div></div>
    <div class="field"><label>Label Badge</label><input name="label" value="{{ old('label',$product->label) }}"></div>
    <div class="field"><label>Urutan</label><input type="number" name="sort_order" value="{{ old('sort_order',$product->sort_order ?? 0) }}"></div>
    <div class="field"><label>Image URL</label><input name="image" value="{{ old('image',$product->image) }}"></div>
    <div class="field"><label>Upload Image</label><input type="file" name="image_file" accept="image/*">@if($product->image_url)<div class="help"><img class="preview" src="{{ $product->image_url }}"></div>@endif</div>
    <label><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured',$product->is_featured ?? false))> Featured</label>
    <label><input type="checkbox" name="is_active" value="1" @checked(old('is_active',$product->is_active ?? true))> Aktif</label>
  </div><br>
  <div class="field"><label>Deskripsi</label><textarea name="description" required>{{ old('description',$product->description) }}</textarea></div><br>
  <h3>Spesifikasi Produk</h3>
  <div id="specRows">
    @php($specs = old('spec_keys') ? collect(old('spec_keys'))->map(fn($key,$i)=>['key'=>$key,'value'=>old('spec_values')[$i] ?? '']) : $product->specs->map(fn($s)=>['key'=>$s->spec_key,'value'=>$s->spec_value]))
    @forelse($specs as $spec)
      <div class="spec-row"><input name="spec_keys[]" value="{{ $spec['key'] }}" placeholder="Nama spec"><input name="spec_values[]" value="{{ $spec['value'] }}" placeholder="Isi spec"><button type="button" class="btn btn-danger" onclick="this.parentElement.remove()">X</button></div>
    @empty
      <div class="spec-row"><input name="spec_keys[]" value="Ukuran" placeholder="Nama spec"><input name="spec_values[]" value="" placeholder="Isi spec"><button type="button" class="btn btn-danger" onclick="this.parentElement.remove()">X</button></div>
    @endforelse
  </div>
  <button type="button" class="btn btn-light" onclick="addSpecRow()">Tambah Spec</button><br><br>
  <button class="btn btn-primary">Simpan Produk</button> <a class="btn btn-light" href="{{ route('admin.products.index') }}">Kembali</a>
</form>
@push('scripts')<script>function addSpecRow(){document.getElementById('specRows').insertAdjacentHTML('beforeend','<div class="spec-row"><input name="spec_keys[]" placeholder="Nama spec"><input name="spec_values[]" placeholder="Isi spec"><button type="button" class="btn btn-danger" onclick="this.parentElement.remove()">X</button></div>')}</script>@endpush
@endsection
