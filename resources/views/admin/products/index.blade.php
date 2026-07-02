@extends('admin.layout')

@section('title','Produk')
@section('page_title','Produk')
@section('page_description','Kelola katalog produk yang tampil di frontend.')

@section('page_action')
    <a class="btn btn-primary" href="{{ route('admin.products.create') }}">Tambah Produk</a>
@endsection

@section('content')
    <div class="card">
        <div class="table-wrap">
            <table class="table product-table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Ukuran</th>
                        <th>Label</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>
                                <div class="product-cell">
                                    <img class="thumb" src="{{ $product->image_url }}" alt="{{ $product->name }}">
                                    <div>
                                        <strong>{{ $product->name }}</strong>
                                        <small>{{ $product->slug }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $product->category?->name ?? '-' }}</td>
                            <td>{{ $product->size ?: 'Custom' }}</td>
                            <td>{{ $product->label ?: '-' }}</td>
                            <td>
                                <span class="pill {{ $product->is_active ? '' : 'pill-red' }}">
                                    {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="actions">
                                <a class="btn btn-light" href="{{ route('admin.products.edit',$product) }}">Edit</a>
                                <form class="inline-form" method="POST" action="{{ route('admin.products.destroy',$product) }}" onsubmit="return confirm('Hapus produk?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty">Belum ada produk.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <br>
        {{ $products->links() }}
    </div>
@endsection
