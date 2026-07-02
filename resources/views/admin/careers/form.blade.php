@extends('admin.layout')
@section('title', $mode === 'create' ? 'Tambah Karir' : 'Edit Karir')
@section('page_title', $mode === 'create' ? 'Tambah Karir' : 'Edit Karir')
@section('page_description','Isi data lowongan pekerjaan yang akan tampil di section Karir frontend.')
@section('content')
<form class="card" method="POST" action="{{ $mode === 'create' ? route('admin.careers.store') : route('admin.careers.update',$career) }}">
  @csrf @if($mode==='edit')@method('PUT')@endif

  <div class="grid grid-2">
    <div class="field"><label>Nama Posisi *</label><input name="title" value="{{ old('title',$career->title) }}" placeholder="Contoh: Sales Executive" required></div>
    <div class="field"><label>Slug</label><input name="slug" value="{{ old('slug',$career->slug) }}" placeholder="otomatis jika dikosongkan"></div>
    <div class="field"><label>Departemen</label><input name="department" value="{{ old('department',$career->department) }}" placeholder="Sales / Marketing / Gudang"></div>
    <div class="field"><label>Lokasi</label><input name="location" value="{{ old('location',$career->location) }}" placeholder="Surabaya / Jakarta / Remote"></div>
    <div class="field"><label>Tipe Pekerjaan</label><input name="employment_type" value="{{ old('employment_type',$career->employment_type) }}" placeholder="Full-time / Part-time / Internship"></div>
    <div class="field"><label>Sistem Kerja</label><input name="work_type" value="{{ old('work_type',$career->work_type) }}" placeholder="On-site / Hybrid / Remote"></div>
    <div class="field"><label>Range Gaji</label><input name="salary_range" value="{{ old('salary_range',$career->salary_range) }}" placeholder="Negotiable / Rp ..."></div>
    <div class="field"><label>Deadline Lamaran</label><input type="date" name="closes_at" value="{{ old('closes_at', optional($career->closes_at)->format('Y-m-d')) }}"></div>
    <div class="field"><label>Apply URL</label><input name="apply_url" value="{{ old('apply_url',$career->apply_url) }}" placeholder="https://forms.gle/... atau link WhatsApp"></div>
    <div class="field"><label>Apply Email</label><input type="email" name="apply_email" value="{{ old('apply_email',$career->apply_email) }}" placeholder="hr@domain.com"></div>
    <div class="field"><label>Urutan</label><input type="number" name="sort_order" value="{{ old('sort_order',$career->sort_order ?? 0) }}"></div>
  </div>

  <br>
  <div class="field"><label>Ringkasan</label><textarea name="summary" rows="4" placeholder="Deskripsi singkat posisi yang tampil di kartu karir">{{ old('summary',$career->summary) }}</textarea></div>
  <br>
  <div class="field"><label>Deskripsi Pekerjaan</label><textarea name="description" rows="8" placeholder="Tanggung jawab, jobdesk, dan informasi posisi. Boleh menggunakan HTML sederhana.">{{ old('description',$career->description) }}</textarea></div>
  <br>
  <div class="field"><label>Kualifikasi / Requirements</label><textarea name="requirements" rows="8" placeholder="Kualifikasi, syarat, dokumen yang dibutuhkan. Boleh menggunakan HTML sederhana.">{{ old('requirements',$career->requirements) }}</textarea></div>
  <br>
  <label class="form-check-inline"><input type="checkbox" name="is_active" value="1" @checked(old('is_active',$career->is_active ?? true))> Aktif</label>
  <br><br>
  <button class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
  <a class="btn btn-light" href="{{ route('admin.careers.index') }}">Kembali</a>
</form>
@endsection
