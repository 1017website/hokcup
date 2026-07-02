@extends('admin.layout')
@section('title','Karir')
@section('page_title','Karir')
@section('page_description','Kelola lowongan pekerjaan yang tampil di frontend.')
@section('page_action')<a class="btn btn-primary" href="{{ route('admin.careers.create') }}"><i class="fas fa-plus"></i> Tambah Karir</a>@endsection
@section('content')
<div class="card">
  <div class="table-wrap compact-content-wrap">
    <table class="table admin-table content-table compact-content-table">
      <thead>
        <tr>
          <th>Posisi</th>
          <th>Departemen</th>
          <th>Lokasi</th>
          <th>Tipe</th>
          <th>Deadline</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($careers as $career)
          <tr>
            <td><div class="content-title-stack no-thumb"><strong>{{ $career->title }}</strong><small>{{ $career->slug }}</small>@if($career->summary)<p>{{ \Illuminate\Support\Str::limit($career->summary, 110) }}</p>@endif</div></td>
            <td>{{ $career->department ?: '-' }}</td>
            <td>{{ $career->location ?: '-' }}</td>
            <td>{{ $career->employment_type ?: '-' }} @if($career->work_type)<br><small>{{ $career->work_type }}</small>@endif</td>
            <td>{{ $career->closes_at?->format('d M Y') ?: '-' }}</td>
            <td><span class="pill {{ $career->is_active ? 'pill-green' : 'pill-red' }}">{{ $career->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
            <td class="actions">
              <a class="btn btn-light" href="{{ route('admin.careers.edit',$career) }}">Edit</a>
              <form class="inline-form" method="POST" action="{{ route('admin.careers.destroy',$career) }}" onsubmit="return confirm('Hapus lowongan ini?')">
                @csrf @method('DELETE')
                <button class="btn btn-danger">Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="7"><div class="empty">Belum ada lowongan karir. Klik tombol tambah untuk membuat lowongan pertama.</div></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div style="margin-top:18px">{{ $careers->links() }}</div>
</div>
@endsection
