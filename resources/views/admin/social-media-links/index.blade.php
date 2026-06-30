@extends('admin.layout')
@section('title','Sosial Media')
@section('page_title','Sosial Media')
@section('page_description','Kelola link Instagram, TikTok, Facebook, marketplace, dan channel brand lain yang tampil di frontend.')
@section('page_action')<a class="btn btn-primary" href="{{ route('admin.social-media-links.create') }}"><i class="fas fa-plus"></i> Tambah Sosial Media</a>@endsection
@section('content')
<div class="card">
  <div class="table-wrap">
    <table class="table">
      <thead><tr><th>Platform</th><th>Username</th><th>URL</th><th>Status</th><th>Aksi</th></tr></thead>
      <tbody>
        @forelse($links as $link)
          <tr>
            <td><strong><i class="{{ $link->icon }}"></i> {{ $link->platform }}</strong><br>{{ $link->description }}</td>
            <td>{{ $link->username ?: '-' }}</td>
            <td><a href="{{ $link->url }}" target="_blank">{{ $link->label ?: $link->url }}</a></td>
            <td><span class="pill {{ $link->is_active ? 'pill-green' : 'pill-red' }}">{{ $link->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
            <td class="actions"><a class="btn btn-light" href="{{ route('admin.social-media-links.edit',$link) }}">Edit</a><form class="inline-form" method="POST" action="{{ route('admin.social-media-links.destroy',$link) }}" onsubmit="return confirm('Hapus sosial media ini?')">@csrf @method('DELETE')<button class="btn btn-danger">Hapus</button></form></td>
          </tr>
        @empty
          <tr><td colspan="5"><div class="empty">Belum ada sosial media. Klik tombol tambah untuk membuat link pertama.</div></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
