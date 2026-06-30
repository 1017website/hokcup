@extends('admin.layout')
@section('title','Produk')
@section('page_title','Produk')
@section('page_description','Kelola katalog produk yang tampil di frontend.')
@section('page_action')<a class="btn btn-primary" href="{{ route('admin.products.create') }}">Tambah Produk</a>@endsection
@section('content')
<div class="card"><table class="table"><thead><tr><th>Produk</th><th>Kategori</th><th>Ukuran</th><th>Label</th><th>Status</th><th>Aksi</th></tr></thead><tbody>@foreach($products as $product)<tr><td style="display:flex;gap:12px"><img class="thumb" src="{{ $product->image_url }}"><div><strong>{{ $product->name }}</strong><br><small>{{ $product->slug }}</small></div></td><td>{{ $product->category?->name }}</td><td>{{ $product->size ?: 'Custom' }}</td><td>{{ $product->label }}</td><td><span class="pill">{{ $product->is_active ? 'Aktif' : 'Nonaktif' }}</span></td><td class="actions"><a class="btn btn-light" href="{{ route('admin.products.edit',$product) }}">Edit</a><form class="inline-form" method="POST" action="{{ route('admin.products.destroy',$product) }}" onsubmit="return confirm('Hapus produk?')">@csrf @method('DELETE')<button class="btn btn-danger">Hapus</button></form></td></tr>@endforeach</tbody></table><br>{{ $products->links() }}</div>
@endsection
