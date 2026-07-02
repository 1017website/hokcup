@extends('admin.layout')
@section('title','Ubah Password CMS')
@section('page_title','Ubah Password')
@section('page_description','Ganti password akun CMS yang sedang Anda gunakan untuk login.')
@section('content')
<div class="grid grid-2">
  <form class="card" method="POST" action="{{ route('admin.profile.password.update') }}">
    @csrf
    @method('PUT')

    <h3>Password Akun</h3>
    <p class="help">Gunakan kombinasi huruf dan angka minimal 8 karakter agar akun CMS lebih aman.</p>

    <div class="admin-divider"></div>

    <div class="field">
      <label>Password Lama</label>
      <input type="password" name="current_password" required autocomplete="current-password">
    </div>
    <br>

    <div class="field">
      <label>Password Baru</label>
      <input type="password" name="password" required autocomplete="new-password">
      <div class="help">Minimal 8 karakter, mengandung huruf dan angka.</div>
    </div>
    <br>

    <div class="field">
      <label>Konfirmasi Password Baru</label>
      <input type="password" name="password_confirmation" required autocomplete="new-password">
    </div>
    <br>

    <button class="btn btn-primary"><i class="fas fa-key"></i> Simpan Password Baru</button>
  </form>

  <div class="card card-soft">
    <h3>Info Akun Login</h3>
    <div class="profile-summary">
      <div class="profile-avatar">{{ strtoupper(mb_substr(auth()->user()->name ?? 'U', 0, 1)) }}</div>
      <div>
        <strong>{{ auth()->user()->name }}</strong>
        <span>{{ auth()->user()->email }}</span>
      </div>
    </div>
    <div class="status-list status-list-compact" style="margin-top:18px">
      <div class="status-item"><strong>Role</strong><span class="pill pill-green">{{ ucfirst(auth()->user()->role ?? 'Admin') }}</span></div>
      <div class="status-item"><strong>Status</strong><span class="pill pill-green">Aktif</span></div>
    </div>
  </div>
</div>
@endsection
