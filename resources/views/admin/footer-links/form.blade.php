@extends('admin.layout')
@section('title', $mode === 'create' ? 'Tambah Footer Link' : 'Edit Footer Link')
@section('page_title', $mode === 'create' ? 'Tambah Footer Link' : 'Edit Footer Link')
@section('content')
<form class="card" method="POST" action="{{ $mode === 'create' ? route('admin.footer-links.store') : route('admin.footer-links.update',$link) }}">@csrf @if($mode==='edit')@method('PUT')@endif
  <div class="grid grid-2"><div class="field"><label>Group</label><input name="group" value="{{ old('group',$link->group ?: 'Menu') }}" required></div><div class="field"><label>Label</label><input name="label" value="{{ old('label',$link->label) }}" required></div><div class="field"><label>URL</label><input name="url" value="{{ old('url',$link->url ?: '#') }}" required></div><div class="field"><label>Onclick</label><input name="onclick" value="{{ old('onclick',$link->onclick) }}"><div class="help">Opsional, contoh: setCategory('natural')</div></div><div class="field"><label>Urutan</label><input type="number" name="sort_order" value="{{ old('sort_order',$link->sort_order ?? 0) }}"></div><label style="align-self:end"><input type="checkbox" name="is_active" value="1" @checked(old('is_active',$link->is_active ?? true))> Aktif</label></div><br>
  <button class="btn btn-primary">Simpan</button> <a class="btn btn-light" href="{{ route('admin.footer-links.index') }}">Kembali</a>
</form>
@endsection
