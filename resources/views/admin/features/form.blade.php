@extends('admin.layout')
@section('title', $mode === 'create' ? 'Tambah Keunggulan' : 'Edit Keunggulan')
@section('page_title', $mode === 'create' ? 'Tambah Keunggulan' : 'Edit Keunggulan')
@section('content')
<form class="card" method="POST" action="{{ $mode === 'create' ? route('admin.features.store') : route('admin.features.update',$feature) }}">@csrf @if($mode==='edit')@method('PUT')@endif
  <div class="grid grid-2"><div class="field"><label>Icon</label><input name="icon" value="{{ old('icon',$feature->icon ?: 'fa-medal') }}" required></div><div class="field"><label>Judul</label><input name="title" value="{{ old('title',$feature->title) }}" required></div><div class="field"><label>Urutan</label><input type="number" name="sort_order" value="{{ old('sort_order',$feature->sort_order ?? 0) }}"></div><label style="align-self:end"><input type="checkbox" name="is_active" value="1" @checked(old('is_active',$feature->is_active ?? true))> Aktif</label></div><br>
  <div class="field"><label>Deskripsi</label><textarea name="description" required>{{ old('description',$feature->description) }}</textarea></div><br>
  <button class="btn btn-primary">Simpan</button> <a class="btn btn-light" href="{{ route('admin.features.index') }}">Kembali</a>
</form>
@endsection
