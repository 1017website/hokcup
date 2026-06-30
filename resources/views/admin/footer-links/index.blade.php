@extends('admin.layout')
@section('title','Footer Links')
@section('page_title','Footer Links')
@section('page_description','Kelola menu link di footer.')
@section('page_action')<a class="btn btn-primary" href="{{ route('admin.footer-links.create') }}">Tambah Link</a>@endsection
@section('content')
<div class="card"><table class="table"><thead><tr><th>Group</th><th>Label</th><th>URL</th><th>Onclick</th><th>Status</th><th>Aksi</th></tr></thead><tbody>@foreach($links as $link)<tr><td>{{ $link->group }}</td><td><strong>{{ $link->label }}</strong></td><td>{{ $link->url }}</td><td>{{ $link->onclick }}</td><td><span class="pill">{{ $link->is_active ? 'Aktif' : 'Nonaktif' }}</span></td><td class="actions"><a class="btn btn-light" href="{{ route('admin.footer-links.edit',$link) }}">Edit</a><form class="inline-form" method="POST" action="{{ route('admin.footer-links.destroy',$link) }}" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="btn btn-danger">Hapus</button></form></td></tr>@endforeach</tbody></table></div>
@endsection
