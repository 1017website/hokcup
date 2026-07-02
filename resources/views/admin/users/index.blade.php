@extends('admin.layout')
@section('title','User CMS')
@section('page_title','User CMS')
@section('page_description','Kelola akun admin, developer, dan editor yang bisa login ke halaman CMS.')
@section('page_action')
  <a class="btn btn-primary" href="{{ route('admin.users.create') }}"><i class="fas fa-user-plus"></i> Tambah User</a>
@endsection
@section('content')
<div class="card">
  <div class="section-note">
    <strong>List user CMS sudah ditampilkan di halaman ini.</strong><br>
    Akun dengan role <b>Developer</b> tetap bisa melihat menu ini selama sudah login ke CMS.
  </div>

  <div class="admin-divider"></div>

  <div class="table-wrap">
    <table class="table user-table">
      <thead>
        <tr>
          <th>User</th>
          <th>Role</th>
          <th>Status</th>
          <th>Dibuat</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($users as $user)
          <tr>
            <td>
              <div class="user-cell">
                <div class="user-avatar">{{ strtoupper(mb_substr($user->name ?: $user->email, 0, 1)) }}</div>
                <div>
                  <strong>{{ $user->name }}</strong>
                  <span>{{ $user->email }}</span>
                  @if($user->id === auth()->id())
                    <small>Anda sedang login dengan akun ini</small>
                  @endif
                </div>
              </div>
            </td>
            <td><span class="pill pill-soft">{{ $roles[$user->role ?? 'admin'] ?? ucfirst($user->role ?? 'Admin') }}</span></td>
            <td>
              <span class="pill {{ ($user->is_active ?? true) ? 'pill-green' : 'pill-red' }}">
                {{ ($user->is_active ?? true) ? 'Aktif' : 'Nonaktif' }}
              </span>
            </td>
            <td>{{ optional($user->created_at)->format('d M Y') ?: '-' }}</td>
            <td class="actions">
              <a class="btn btn-light" href="{{ route('admin.users.edit', $user) }}"><i class="fas fa-pen"></i> Edit</a>
              @if($user->id !== auth()->id())
                <form class="inline-form" method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Hapus user ini?')">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button>
                </form>
              @endif
            </td>
          </tr>
        @empty
          <tr><td colspan="5">Belum ada user CMS.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <br>
  {{ $users->links() }}
</div>
@endsection
