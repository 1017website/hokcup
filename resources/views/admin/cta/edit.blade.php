@extends('admin.layout')
@section('title','CTA')
@section('page_title','CTA Kontak')
@section('page_description','Kelola section merah sebelum footer.')
@section('content')
<form class="card" method="POST" action="{{ route('admin.cta.update') }}">@csrf @method('PUT')
  <div class="grid grid-2"><div class="field"><label>Judul</label><input name="title" value="{{ old('title',$cta->title) }}" required></div><div class="field"><label>Teks Tombol</label><input name="button_text" value="{{ old('button_text',$cta->button_text) }}" required></div><div class="field"><label>Icon Tombol</label><input name="button_icon" value="{{ old('button_icon',$cta->button_icon) }}"></div><div class="field"><label>Pesan WhatsApp</label><input name="whatsapp_message" value="{{ old('whatsapp_message',$cta->whatsapp_message) }}" required></div></div><br>
  <div class="field"><label>Deskripsi</label><textarea name="description" required>{{ old('description',$cta->description) }}</textarea></div><br>
  <button class="btn btn-primary">Simpan CTA</button>
</form>
@endsection
