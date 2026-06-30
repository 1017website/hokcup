@extends('admin.layout')
@section('title','Hero Section')
@section('page_title','Hero Section')
@section('page_description','Kelola teks hero utama, gambar, kartu, dan trust chip.')
@section('content')
<form class="card" method="POST" action="{{ route('admin.hero.update') }}" enctype="multipart/form-data">
  @csrf @method('PUT')
  <h3>Konten Hero</h3>
  <div class="grid grid-2">
    <div class="field"><label>Eyebrow Icon</label><input name="eyebrow_icon" value="{{ old('eyebrow_icon',$hero->eyebrow_icon) }}"></div>
    <div class="field"><label>Eyebrow Text</label><input name="eyebrow_text" value="{{ old('eyebrow_text',$hero->eyebrow_text) }}" required></div>
    <div class="field"><label>Judul Sebelum Pill</label><input name="title_before" value="{{ old('title_before',$hero->title_before) }}" required></div>
    <div class="field"><label>Kata Pill Kuning</label><input name="pill_word" value="{{ old('pill_word',$hero->pill_word) }}" required></div>
    <div class="field"><label>Judul Setelah Line Break</label><input name="title_after" value="{{ old('title_after',$hero->title_after) }}" required></div>
    <div class="field"><label>Gambar Hero URL</label><input name="image" value="{{ old('image',$hero->image) }}"></div>
    <div class="field"><label>Upload Gambar Hero</label><input type="file" name="image_file" accept="image/*">@if($hero->image_url)<div class="help"><img class="preview" src="{{ $hero->image_url }}"></div>@endif</div>
  </div><br>
  <div class="field"><label>Deskripsi</label><textarea name="description" required>{{ old('description',$hero->description) }}</textarea></div><br>
  <div class="grid grid-2">
    <div class="field"><label>Tombol Utama</label><input name="primary_button_text" value="{{ old('primary_button_text',$hero->primary_button_text) }}"></div>
    <div class="field"><label>Icon Tombol Utama</label><input name="primary_button_icon" value="{{ old('primary_button_icon',$hero->primary_button_icon) }}"></div>
    <div class="field"><label>Tombol Kedua</label><input name="secondary_button_text" value="{{ old('secondary_button_text',$hero->secondary_button_text) }}"></div>
    <div class="field"><label>Icon Tombol Kedua</label><input name="secondary_button_icon" value="{{ old('secondary_button_icon',$hero->secondary_button_icon) }}"></div>
  </div>
  <h3>Kartu Floating</h3>
  <div class="grid grid-3">
    <div class="field"><label>Card A Angka</label><input name="card_a_number" value="{{ old('card_a_number',$hero->card_a_number) }}"><label>Card A Text</label><input name="card_a_text" value="{{ old('card_a_text',$hero->card_a_text) }}"><label>Card A Icon</label><input name="card_a_icon" value="{{ old('card_a_icon',$hero->card_a_icon) }}"></div>
    <div class="field"><label>Card B Angka</label><input name="card_b_number" value="{{ old('card_b_number',$hero->card_b_number) }}"><label>Card B Text</label><input name="card_b_text" value="{{ old('card_b_text',$hero->card_b_text) }}"><label>Card B Icon</label><input name="card_b_icon" value="{{ old('card_b_icon',$hero->card_b_icon) }}"></div>
    <div class="field"><label>Card C Angka</label><input name="card_c_number" value="{{ old('card_c_number',$hero->card_c_number) }}"><label>Card C Text</label><input name="card_c_text" value="{{ old('card_c_text',$hero->card_c_text) }}"><label>Card C Icon</label><input name="card_c_icon" value="{{ old('card_c_icon',$hero->card_c_icon) }}"></div>
  </div>
  <h3>Trust Chip</h3>
  <div id="trustRows">
    @foreach($trustItems as $i => $item)
      <div class="spec-row"><input name="trust_icon[]" value="{{ $item->icon }}"><input name="trust_text[]" value="{{ $item->text }}"><label><input type="checkbox" name="trust_active[{{ $i }}]" value="1" @checked($item->is_active)> Aktif</label></div>
    @endforeach
  </div>
  <button type="button" class="btn btn-light" onclick="addTrustRow()">Tambah Trust Chip</button><br><br>
  <button class="btn btn-primary">Simpan Hero</button>
</form>
@push('scripts')<script>function addTrustRow(){const i=document.querySelectorAll('#trustRows .spec-row').length;document.getElementById('trustRows').insertAdjacentHTML('beforeend',`<div class="spec-row"><input name="trust_icon[]" value="fa-check-circle"><input name="trust_text[]" placeholder="Text"><label><input type="checkbox" name="trust_active[${i}]" value="1" checked> Aktif</label></div>`)}</script>@endpush
@endsection
