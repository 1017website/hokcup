@extends('admin.layout')
@section('title','Keunggulan')
@section('page_title','Keunggulan')
@section('page_description','Kelola card keunggulan di website.')
@section('page_action')<a class="btn btn-primary" href="{{ route('admin.features.create') }}">Tambah</a>@endsection
@section('content')
<div class="card"><table class="table"><thead><tr><th>Judul</th><th>Icon</th><th>Status</th><th>Aksi</th></tr></thead><tbody>@foreach($features as $feature)<tr><td><strong>{{ $feature->title }}</strong><br>{{ $feature->description }}</td><td><i class="fas {{ $feature->icon }}"></i> {{ $feature->icon }}</td><td><span class="pill">{{ $feature->is_active ? 'Aktif' : 'Nonaktif' }}</span></td><td class="actions"><a class="btn btn-light" href="{{ route('admin.features.edit',$feature) }}">Edit</a><form class="inline-form" method="POST" action="{{ route('admin.features.destroy',$feature) }}" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="btn btn-danger">Hapus</button></form></td></tr>@endforeach</tbody></table></div>
@endsection
