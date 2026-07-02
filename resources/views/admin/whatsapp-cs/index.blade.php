@extends('admin.layout')
@section('title','CS WhatsApp')
@section('page_title','CS WhatsApp')
@section('page_description','Kelola beberapa nomor customer service. Tombol WhatsApp frontend akan otomatis dibagi rata ke CS dengan jumlah click paling sedikit.')
@section('page_action')
  <a class="btn btn-light" href="{{ route('home') }}" target="_blank"><i class="fas fa-globe"></i> Test Website</a>
@endsection
@section('content')
<div class="section-note">
  <strong>Sistem Round-Robin:</strong> setiap pengunjung klik tombol WhatsApp, sistem memilih CS aktif dengan <b>total click paling sedikit</b>. Dengan begitu pembagian leads lebih merata antar CS.
</div>

<div class="stat-grid stat-grid-4" style="margin-top:16px">
  <div class="stat-card"><i class="fab fa-whatsapp"></i><strong>{{ number_format($activeCount) }}</strong><span>CS Aktif</span></div>
  <div class="stat-card"><i class="fas fa-mouse-pointer"></i><strong>{{ number_format($totalClicks) }}</strong><span>Total Click WA</span></div>
  <div class="stat-card"><i class="fas fa-calendar-day"></i><strong>{{ number_format($clicksToday) }}</strong><span>Click Hari Ini</span></div>
  <div class="stat-card"><i class="fas fa-calendar-days"></i><strong>{{ number_format($clicks30Days) }}</strong><span>Click 30 Hari</span></div>
</div>

<form class="card" method="POST" action="{{ route('admin.whatsapp-cs.store') }}">
  @csrf
  <h3>Tambah CS Baru</h3>
  <div class="grid grid-4">
    <div class="field">
      <label>Nama CS *</label>
      <input name="name" value="{{ old('name') }}" placeholder="Rina, Budi, CS 1..." required>
    </div>
    <div class="field">
      <label>No. WhatsApp *</label>
      <input name="phone_number" value="{{ old('phone_number') }}" placeholder="6281234567890" required>
      <div class="help">Format: <code>628xxx</code>. Jika isi <code>08xxx</code>, sistem otomatis ubah ke <code>628xxx</code>.</div>
    </div>
    <div class="field">
      <label>Tampilan Nomor</label>
      <input name="display_number" value="{{ old('display_number') }}" placeholder="+62 812-xxx">
    </div>
    <div class="field">
      <label>Urutan</label>
      <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
    </div>
  </div>
  <div class="grid grid-2" style="margin-top:14px">
    <div class="field">
      <label>Pesan Greeting WA</label>
      <textarea name="greeting_message" placeholder="Halo, saya ingin bertanya tentang produk...">{{ old('greeting_message') }}</textarea>
      <div class="help">Dipakai sebagai pesan default jika tombol WA tidak mengirim pesan khusus.</div>
    </div>
    <div class="field wa-active-box">
      <label>Status</label>
      <label class="switch-row">
        <input type="checkbox" name="is_active" value="1" checked>
        <span>Aktif</span>
      </label>
      <button class="btn btn-primary" type="submit"><i class="fas fa-plus"></i> Tambah CS</button>
    </div>
  </div>
</form>

<div class="card">
  <div class="card-head-inline">
    <div>
      <h3>List CS WhatsApp</h3>
      <p class="help">Edit data langsung pada baris, lalu klik tombol simpan.</p>
    </div>
    <form method="POST" action="{{ route('admin.whatsapp-cs.reset-stats') }}" onsubmit="return confirm('Reset semua statistik click WhatsApp?')">
      @csrf
      <button class="btn btn-light" type="submit"><i class="fas fa-rotate-left"></i> Reset Statistik</button>
    </form>
  </div>

  @if($services->isEmpty())
    <div class="empty">Belum ada CS WhatsApp. Tambahkan CS pertama di form atas.</div>
  @else
    <div class="table-wrap">
      <table class="table wa-cs-table">
        <thead>
          <tr>
            <th>Nama CS</th>
            <th>WhatsApp</th>
            <th>Greeting</th>
            <th>Urut</th>
            <th>Total Click</th>
            <th>30 Hari</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($services as $service)
            <tr>
              <td>
                <input form="cs-form-{{ $service->id }}" name="name" value="{{ old('name_'.$service->id, $service->name) }}" required>
              </td>
              <td>
                <input form="cs-form-{{ $service->id }}" name="phone_number" value="{{ $service->phone_number }}" required>
                <input form="cs-form-{{ $service->id }}" name="display_number" value="{{ $service->display_number }}" placeholder="Tampilan nomor" style="margin-top:8px">
              </td>
              <td>
                <textarea form="cs-form-{{ $service->id }}" name="greeting_message" rows="2" placeholder="Pesan greeting">{{ $service->greeting_message }}</textarea>
              </td>
              <td>
                <input form="cs-form-{{ $service->id }}" type="number" name="sort_order" value="{{ $service->sort_order }}" min="0">
              </td>
              <td><strong>{{ number_format($service->total_clicks) }}</strong></td>
              <td>{{ number_format($service->clicks_30_days_count) }}</td>
              <td>
                <label class="switch-row switch-row-compact">
                  <input form="cs-form-{{ $service->id }}" type="checkbox" name="is_active" value="1" @checked($service->is_active)>
                  <span>{{ $service->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                </label>
              </td>
              <td>
                <div class="actions">
                  <form id="cs-form-{{ $service->id }}" method="POST" action="{{ route('admin.whatsapp-cs.update', $service) }}">
                    @csrf
                    @method('PUT')
                    <button class="btn btn-primary" type="submit"><i class="fas fa-save"></i></button>
                  </form>
                  <form method="POST" action="{{ route('admin.whatsapp-cs.destroy', $service) }}" onsubmit="return confirm('Hapus CS ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit"><i class="fas fa-trash"></i></button>
                  </form>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
</div>

@if($services->isNotEmpty())
<div class="grid grid-2">
  <div class="card">
    <h3>Distribusi Click per CS</h3>
    <div class="wa-distribution">
      @foreach($services as $service)
        @php
          $percent = $totalClicks > 0 ? round(($service->total_clicks / $totalClicks) * 100) : 0;
        @endphp
        <div class="wa-progress-item">
          <div>
            <strong>{{ $service->name }}</strong>
            <span>{{ number_format($service->total_clicks) }} click — {{ $percent }}%</span>
          </div>
          <em><i style="width:{{ max($percent, $service->total_clicks > 0 ? 4 : 0) }}%"></i></em>
        </div>
      @endforeach
    </div>
  </div>

  <div class="card card-soft">
    <h3>Cara Kerja di Frontend</h3>
    <div class="status-list status-list-compact" style="margin-top:16px">
      <div class="status-item"><strong>Navbar WA</strong><span class="pill pill-green">Round-Robin</span></div>
      <div class="status-item"><strong>Floating WA</strong><span class="pill pill-green">Round-Robin</span></div>
      <div class="status-item"><strong>Modal Produk</strong><span class="pill pill-green">Round-Robin + Produk</span></div>
      <div class="status-item"><strong>CTA Kontak</strong><span class="pill pill-green">Round-Robin</span></div>
    </div>
    <p class="help" style="margin-top:14px">Kalau semua CS nonaktif, sistem memakai nomor fallback dari <b>Site Setting & WA</b>.</p>
  </div>
</div>
@endif
@endsection
