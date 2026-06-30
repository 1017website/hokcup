@extends('admin.layout')
@section('title','Social Proof')
@section('page_title','Social Proof')
@section('page_description','Kelola embed Instagram, Google Reviews, dan widget lain.')
@section('page_action')<a class="btn btn-primary" href="{{ route('admin.social-widgets.create') }}">Tambah Widget</a>@endsection
@section('content')
<div class="card"><table class="table"><thead><tr><th>Widget</th><th>Icon</th><th>Status</th><th>Aksi</th></tr></thead><tbody>@foreach($widgets as $widget)<tr><td><strong>{{ $widget->title }}</strong><br>{{ $widget->description }}</td><td>{{ $widget->icon }}</td><td><span class="pill">{{ $widget->is_active ? 'Aktif' : 'Nonaktif' }}</span></td><td class="actions"><a class="btn btn-light" href="{{ route('admin.social-widgets.edit',$widget) }}">Edit</a><form class="inline-form" method="POST" action="{{ route('admin.social-widgets.destroy',$widget) }}" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="btn btn-danger">Hapus</button></form></td></tr>@endforeach</tbody></table></div>
@endsection
