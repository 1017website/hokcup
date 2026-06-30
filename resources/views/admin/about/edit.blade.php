@extends('admin.layout')
@section('title','Tentang')
@section('page_title','Tentang')
@section('page_description','Kelola bagian Tentang dan statistik mini.')
@section('content')
<form class="card" method="POST" action="{{ route('admin.about.update') }}" enctype="multipart/form-data">@csrf @method('PUT')
  <div class="grid grid-2"><div class="field"><label>Eyebrow Icon</label><input name="eyebrow_icon" value="{{ old('eyebrow_icon',$about->eyebrow_icon) }}"></div><div class="field"><label>Eyebrow Text</label><input name="eyebrow_text" value="{{ old('eyebrow_text',$about->eyebrow_text) }}"></div><div class="field"><label>Judul</label><input name="title" value="{{ old('title',$about->title) }}" required></div><div class="field"><label>Image URL</label><input name="image" value="{{ old('image',$about->image) }}"></div><div class="field"><label>Upload Image</label><input type="file" name="image_file" accept="image/*">@if($about->image_url)<div class="help"><img class="preview" src="{{ $about->image_url }}"></div>@endif</div></div><br>
  <div class="field"><label>Deskripsi</label><textarea name="description" required>{{ old('description',$about->description) }}</textarea></div><br>
  <h3>Statistik</h3><div id="statRows">@foreach($stats as $i => $stat)<div class="spec-row"><input name="stat_number[]" value="{{ $stat->number }}"><input name="stat_label[]" value="{{ $stat->label }}"><label><input type="checkbox" name="stat_active[{{ $i }}]" value="1" @checked($stat->is_active)> Aktif</label></div>@endforeach</div><button type="button" class="btn btn-light" onclick="addStatRow()">Tambah Statistik</button><br><br>
  <button class="btn btn-primary">Simpan Tentang</button>
</form>
@push('scripts')<script>function addStatRow(){const i=document.querySelectorAll('#statRows .spec-row').length;document.getElementById('statRows').insertAdjacentHTML('beforeend',`<div class="spec-row"><input name="stat_number[]" placeholder="12+"><input name="stat_label[]" placeholder="Produk"><label><input type="checkbox" name="stat_active[${i}]" value="1" checked> Aktif</label></div>`)}</script>@endpush
@endsection
