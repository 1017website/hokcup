@extends('admin.layout')

@section('title','Detail Data Mitra')
@section('page_title','Detail Data Mitra')
@section('page_description','Lihat detail calon mitra dari form Jadi Mitra HokCup.')
@section('page_action')
  <a class="btn btn-light" href="{{ route('admin.partnership-inquiries.index') }}"><i class="fas fa-arrow-left"></i> Kembali</a>
@endsection

@section('content')
<div class="grid grid-2">
  <div class="card">
    <h3>Informasi Calon Mitra</h3>
    <div class="detail-list">
      <div><strong>Nama Lengkap</strong><span>{{ $inquiry->name }}</span></div>
      <div><strong>Nama Usaha / Brand</strong><span>{{ $inquiry->business_name }}</span></div>
      <div><strong>Nomor WhatsApp</strong><span>{{ $inquiry->phone }}</span></div>
      <div><strong>Kota / Domisili</strong><span>{{ $inquiry->city }}</span></div>
      <div><strong>Jenis Mitra</strong><span>{{ $inquiry->partner_type }}</span></div>
      <div><strong>Estimasi Kebutuhan</strong><span>{{ $inquiry->estimated_need }}</span></div>
      <div><strong>Tanggal Masuk</strong><span>{{ $inquiry->created_at?->format('d M Y H:i') }}</span></div>
      <div><strong>Status</strong><span class="pill {{ $inquiry->status === 'new' ? 'pill-red' : ($inquiry->status === 'contacted' ? 'pill-green' : 'pill-soft') }}">{{ $inquiry->status_label }}</span></div>
    </div>
  </div>

  <div class="card card-soft">
    <h3>Tindak Lanjut</h3>
    <p class="help">Ubah status setelah tim menghubungi calon mitra.</p>
    <form method="POST" action="{{ route('admin.partnership-inquiries.update', $inquiry) }}" class="grid" style="margin-top:14px">
      @csrf
      @method('PUT')
      <div class="field">
        <label>Status</label>
        <select name="status" required>
          @foreach($statuses as $key => $label)
            <option value="{{ $key }}" @selected($inquiry->status === $key)>{{ $label }}</option>
          @endforeach
        </select>
      </div>
      @if($inquiry->contacted_at)
        <p class="help">Dihubungi pada: {{ $inquiry->contacted_at->format('d M Y H:i') }}</p>
      @endif
      <div class="actions">
        <button class="btn btn-primary" type="submit"><i class="fas fa-save"></i> Simpan Status</button>
        <a class="btn btn-light" href="{{ $inquiry->whatsapp_url }}" target="_blank"><i class="fab fa-whatsapp"></i> Chat WhatsApp</a>
      </div>
    </form>
  </div>
</div>

<div class="card">
  <h3>Catatan Kebutuhan Produk</h3>
  <div class="section-note">{{ $inquiry->message ?: 'Tidak ada catatan tambahan.' }}</div>
</div>

<div class="card">
  <h3>Informasi Teknis</h3>
  <div class="detail-list detail-list-technical">
    <div><strong>Source URL</strong><span>{{ $inquiry->source_url ?: '-' }}</span></div>
    <div><strong>IP Address</strong><span>{{ $inquiry->ip_address ?: '-' }}</span></div>
    <div><strong>User Agent</strong><span>{{ $inquiry->user_agent ?: '-' }}</span></div>
  </div>
</div>
@endsection
