@extends('admin.layout')

@section('title','Data Mitra HokCup')
@section('page_title','Data Mitra HokCup')
@section('page_description','Data calon mitra yang mengisi form Jadi Mitra HokCup di frontend.')

@section('content')
<div class="stat-grid stat-grid-4">
  <div class="stat-card"><i class="fas fa-handshake"></i><strong>{{ number_format($totalCount) }}</strong><span>Total Data Mitra</span></div>
  <div class="stat-card stat-card-soft"><i class="fas fa-bell"></i><strong>{{ number_format($newCount) }}</strong><span>Belum Dihubungi</span></div>
  <div class="stat-card stat-card-soft"><i class="fas fa-phone"></i><strong>{{ number_format($contactedCount) }}</strong><span>Sudah Dihubungi</span></div>
  <div class="stat-card stat-card-soft"><i class="fas fa-filter"></i><strong>{{ $status ? ($statuses[$status] ?? '-') : 'Semua' }}</strong><span>Filter Aktif</span></div>
</div>

<div class="card">
  <div class="cms-filter-row">
    <a class="btn {{ !$status ? 'btn-primary' : 'btn-light' }}" href="{{ route('admin.partnership-inquiries.index') }}">Semua</a>
    @foreach($statuses as $key => $label)
      <a class="btn {{ $status === $key ? 'btn-primary' : 'btn-light' }}" href="{{ route('admin.partnership-inquiries.index', ['status' => $key]) }}">{{ $label }}</a>
    @endforeach
  </div>

  <div class="table-wrap">
    <table class="table content-table partnership-table">
      <thead>
        <tr>
          <th>Calon Mitra</th>
          <th>Kontak</th>
          <th>Jenis</th>
          <th>Kebutuhan</th>
          <th>Status</th>
          <th>Tanggal</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($inquiries as $inquiry)
          <tr>
            <td>
              <div class="content-cell">
                <div class="content-thumb"><i class="fas fa-handshake"></i></div>
                <div class="content-title-stack">
                  <strong>{{ $inquiry->name }}</strong>
                  <small>{{ $inquiry->business_name }}</small>
                  @if($inquiry->message)
                    <p>{{ $inquiry->message }}</p>
                  @endif
                </div>
              </div>
            </td>
            <td>
              <strong>{{ $inquiry->phone }}</strong><br>
              <small>{{ $inquiry->city }}</small>
            </td>
            <td>{{ $inquiry->partner_type }}</td>
            <td>{{ $inquiry->estimated_need }}</td>
            <td>
              <span class="pill {{ $inquiry->status === 'new' ? 'pill-red' : ($inquiry->status === 'contacted' ? 'pill-green' : 'pill-soft') }}">{{ $inquiry->status_label }}</span>
            </td>
            <td>{{ $inquiry->created_at?->format('d M Y H:i') }}</td>
            <td class="actions">
              <a class="btn btn-light" href="{{ route('admin.partnership-inquiries.show', $inquiry) }}">Detail</a>
              <a class="btn btn-primary" href="{{ $inquiry->whatsapp_url }}" target="_blank"><i class="fab fa-whatsapp"></i> WA</a>
              <form class="inline-form" method="POST" action="{{ route('admin.partnership-inquiries.destroy', $inquiry) }}" onsubmit="return confirm('Hapus data mitra ini?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" type="submit">Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7"><div class="empty">Belum ada data calon mitra.</div></td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <br>
  {{ $inquiries->links() }}
</div>
@endsection
