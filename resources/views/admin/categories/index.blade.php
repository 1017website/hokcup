@extends('admin.layout')
@section('title','Kategori')
@section('page_title','Kategori Produk')
@section('page_description','Kelola kategori yang tampil pada filter dan kartu kategori.')
@section('page_action')<a class="btn btn-primary" href="{{ route('admin.categories.create') }}">Tambah Kategori</a>@endsection
@section('content')
<div class="card"><table class="table"><thead><tr><th>Nama</th><th>Slug</th><th>Icon</th><th>Produk</th><th>Status</th><th>Aksi</th></tr></thead><tbody>@foreach($categories as $category)<tr><td><strong>{{ $category->name }}</strong><br>{{ $category->description }}</td><td>{{ $category->slug }}</td><td><i class="fas {{ $category->icon }}"></i> {{ $category->icon }}</td><td>{{ $category->products_count }}</td><td><span class="pill">{{ $category->is_active ? 'Aktif' : 'Nonaktif' }}</span></td><td class="actions"><a class="btn btn-light" href="{{ route('admin.categories.edit',$category) }}">Edit</a><form class="inline-form" method="POST" action="{{ route('admin.categories.destroy',$category) }}" onsubmit="return confirm('Hapus kategori?')">@csrf @method('DELETE')<button class="btn btn-danger">Hapus</button></form></td></tr>@endforeach</tbody></table></div>
@endsection
