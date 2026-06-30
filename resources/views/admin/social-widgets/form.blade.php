@extends('admin.layout')
@section('title', $mode === 'create' ? 'Tambah Widget' : 'Edit Widget')
@section('page_title', $mode === 'create' ? 'Tambah Widget' : 'Edit Widget')
@section('content')
<form class="card" method="POST" action="{{ $mode === 'create' ? route('admin.social-widgets.store') : route('admin.social-widgets.update',$widget) }}">@csrf @if($mode==='edit')@method('PUT')@endif
  <div class="grid grid-2"><div class="field"><label>Icon Class</label><input name="icon" value="{{ old('icon',$widget->icon ?: 'fas fa-star') }}" required><div class="help">Untuk widget ini boleh lengkap: fab fa-instagram / fas fa-star.</div></div><div class="field"><label>Judul</label><input name="title" value="{{ old('title',$widget->title) }}" required></div><div class="field"><label>Urutan</label><input type="number" name="sort_order" value="{{ old('sort_order',$widget->sort_order ?? 0) }}"></div><label style="align-self:end"><input type="checkbox" name="is_active" value="1" @checked(old('is_active',$widget->is_active ?? true))> Aktif</label></div><br>
  <div class="field"><label>Deskripsi</label><textarea name="description">{{ old('description',$widget->description) }}</textarea></div><br>
  <div class="field"><label>Embed Code</label><textarea name="embed_code" style="min-height:170px">{{ old('embed_code',$widget->embed_code) }}</textarea></div><br>
  <button class="btn btn-primary">Simpan</button> <a class="btn btn-light" href="{{ route('admin.social-widgets.index') }}">Kembali</a>
</form>
@endsection
