@extends('admin.layout')
@section('title','News & Artikel')
@section('page_title','News & Artikel')
@section('page_description','Kelola artikel, berita, promo editorial, atau update terbaru yang tampil di frontend.')
@section('page_action')<a class="btn btn-primary" href="{{ route('admin.news.create') }}"><i class="fas fa-plus"></i> Tambah News</a>@endsection
@section('content')
<div class="card">
  <div class="table-wrap">
    <table class="table admin-table content-table">
      <thead>
        <tr>
          <th>Artikel</th>
          <th>Author</th>
          <th>Tanggal Publish</th>
          <th>Urutan</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($articles as $article)
          <tr>
            <td>
              <div class="content-cell">
                @if($article->image_url)
                  <img src="{{ $article->image_url }}" alt="{{ $article->title }}">
                @else
                  <div class="content-thumb"><i class="fas fa-newspaper"></i></div>
                @endif
                <div>
                  <strong>{{ $article->title }}</strong>
                  <small>{{ $article->slug }}</small>
                  @if($article->excerpt)<p>{{ \Illuminate\Support\Str::limit($article->excerpt, 90) }}</p>@endif
                </div>
              </div>
            </td>
            <td>{{ $article->author ?: '-' }}</td>
            <td>{{ $article->published_at?->format('d M Y H:i') ?: '-' }}</td>
            <td>{{ $article->sort_order }}</td>
            <td>
              <span class="pill {{ $article->is_active ? 'pill-green' : 'pill-red' }}">{{ $article->is_active ? 'Aktif' : 'Nonaktif' }}</span>
              @if($article->is_featured)<span class="pill">Featured</span>@endif
            </td>
            <td class="actions">
              <a class="btn btn-light" href="{{ route('admin.news.edit',$article) }}">Edit</a>
              <form class="inline-form" method="POST" action="{{ route('admin.news.destroy',$article) }}" onsubmit="return confirm('Hapus news ini?')">
                @csrf @method('DELETE')
                <button class="btn btn-danger">Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="6"><div class="empty">Belum ada news. Klik tombol tambah untuk membuat artikel pertama.</div></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div style="margin-top:18px">{{ $articles->links() }}</div>
</div>
@endsection
