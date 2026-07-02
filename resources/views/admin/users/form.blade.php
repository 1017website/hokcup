@extends('admin.layout')
@section('title', $mode === 'create' ? 'Tambah User CMS' : 'Edit User CMS')
@section('page_title', $mode === 'create' ? 'Tambah User CMS' : 'Edit User CMS')
@section('page_description','Atur akses login untuk admin, developer, atau editor CMS.')
@section('content')
<form class="card" method="POST" action="{{ $mode === 'create' ? route('admin.users.store') : route('admin.users.update', $user) }}">
  @csrf
  @if($mode === 'edit') @method('PUT') @endif

  <div class="grid grid-2">
    <div class="field">
      <label>Nama</label>
      <input name="name" value="{{ old('name', $user->name) }}" required>
    </div>

    <div class="field">
      <label>Email Login</label>
      <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
    </div>

    <div class="field">
      <label>Role</label>
      <select name="role" required>
        @foreach($roles as $value => $label)
          <option value="{{ $value }}" @selected(old('role', $user->role ?? 'admin') === $value)>{{ $label }}</option>
        @endforeach
      </select>
      <div class="help">Role Developer tetap bisa melihat menu User CMS.</div>
    </div>

    <div class="field">
      <label>Status</label>
      <select name="is_active" @disabled($mode === 'edit' && $user->id === auth()->id())>
        <option value="1" @selected(old('is_active', $user->is_active ?? true))>Aktif</option>
        <option value="0" @selected(!old('is_active', $user->is_active ?? true))>Nonaktif</option>
      </select>
      @if($mode === 'edit' && $user->id === auth()->id())
        <div class="help">Akun yang sedang login tidak bisa dinonaktifkan dari halaman ini.</div>
      @endif
    </div>
  </div>

  <div class="admin-divider"></div>

  <div class="grid grid-2">
    <div class="field">
      <label>{{ $mode === 'create' ? 'Password' : 'Password Baru' }}</label>
      <input type="password" name="password" @if($mode === 'create') required @endif autocomplete="new-password">
      <div class="help">{{ $mode === 'create' ? 'Wajib diisi.' : 'Kosongkan jika tidak ingin mengganti password.' }} Minimal 8 karakter, mengandung huruf dan angka.</div>
    </div>

    <div class="field">
      <label>Konfirmasi Password</label>
      <input type="password" name="password_confirmation" @if($mode === 'create') required @endif autocomplete="new-password">
    </div>
  </div>

  <br>
  <button class="btn btn-primary"><i class="fas fa-save"></i> Simpan User</button>
  <a class="btn btn-light" href="{{ route('admin.users.index') }}">Kembali</a>
</form>
@endsection
