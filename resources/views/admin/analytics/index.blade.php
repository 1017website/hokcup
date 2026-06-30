@extends('admin.layout')
@section('title','Visitor Analytics')
@section('page_title','Visitor Analytics')
@section('page_description','Pantau total pengunjung, page view, traffic harian, sumber trafik, dan perangkat yang dipakai visitor.')
@section('page_action')
  <form method="GET" class="inline-form">
    <select class="range-select" name="range" onchange="this.form.submit()">
      @foreach([7 => '7 hari', 30 => '30 hari', 90 => '90 hari', 365 => '1 tahun'] as $value => $label)
        <option value="{{ $value }}" @selected($range === $value)>{{ $label }}</option>
      @endforeach
    </select>
  </form>
@endsection
@section('content')
<div class="stat-grid stat-grid-4">
  <div class="stat-card"><i class="fas fa-users"></i><strong>{{ number_format($totalVisitors) }}</strong><span>Total Pengunjung</span></div>
  <div class="stat-card"><i class="fas fa-eye"></i><strong>{{ number_format($totalViews) }}</strong><span>Total Page View</span></div>
  <div class="stat-card"><i class="fas fa-user-check"></i><strong>{{ number_format($todayVisitors) }}</strong><span>Pengunjung Hari Ini</span></div>
  <div class="stat-card"><i class="fas fa-calendar-days"></i><strong>{{ number_format($monthVisitors) }}</strong><span>Pengunjung Bulan Ini</span></div>
</div>

<div class="stat-grid stat-grid-4">
  <div class="stat-card stat-card-soft"><i class="fas fa-chart-line"></i><strong>{{ number_format($rangeVisitors) }}</strong><span>Pengunjung {{ $range }} Hari</span></div>
  <div class="stat-card stat-card-soft"><i class="fas fa-chart-simple"></i><strong>{{ number_format($rangeViews) }}</strong><span>Views {{ $range }} Hari</span></div>
  <div class="stat-card stat-card-soft"><i class="fas fa-eye"></i><strong>{{ number_format($todayViews) }}</strong><span>Views Hari Ini</span></div>
  <div class="stat-card stat-card-soft"><i class="fas fa-calendar"></i><strong>{{ number_format($monthViews) }}</strong><span>Views Bulan Ini</span></div>
</div>

<div class="card">
  <div class="card-head-inline">
    <h3>Traffic Harian</h3>
    <span class="pill">{{ $range }} hari terakhir</span>
  </div>
  <div class="mini-chart">
    @foreach($dailyTraffic as $row)
      @php $height = max(6, round(($row['views'] / $maxDailyViews) * 100)); @endphp
      <div class="mini-chart-item" title="{{ $row['label'] }}: {{ $row['views'] }} views, {{ $row['visitors'] }} pengunjung">
        <div class="mini-chart-bars">
          <span style="height: {{ $height }}%"></span>
        </div>
        <small>{{ $row['label'] }}</small>
      </div>
    @endforeach
  </div>
</div>

<div class="grid grid-3">
  <div class="card">
    <h3>Top Pages</h3>
    <div class="progress-list">
      @forelse($topPages as $page)
        @php $percent = $rangeViews ? round(($page->total / $rangeViews) * 100) : 0; @endphp
        <div class="progress-item">
          <div><strong>{{ $page->path ?: '/' }}</strong><span>{{ number_format($page->total) }} views · {{ $percent }}%</span></div>
          <em><i style="width: {{ $percent }}%"></i></em>
        </div>
      @empty
        <div class="empty">Belum ada data halaman.</div>
      @endforelse
    </div>
  </div>

  <div class="card">
    <h3>Sumber Trafik</h3>
    <div class="progress-list">
      @forelse($trafficSources as $source)
        @php $percent = $rangeViews ? round(($source->total / $rangeViews) * 100) : 0; @endphp
        <div class="progress-item">
          <div><strong>{{ $source->source ?: 'Direct' }}</strong><span>{{ number_format($source->total) }} views · {{ $percent }}%</span></div>
          <em><i style="width: {{ $percent }}%"></i></em>
        </div>
      @empty
        <div class="empty">Belum ada data sumber trafik.</div>
      @endforelse
    </div>
  </div>

  <div class="card">
    <h3>Perangkat</h3>
    <div class="progress-list">
      @forelse($devices as $device)
        @php $percent = $rangeViews ? round(($device->total / $rangeViews) * 100) : 0; @endphp
        <div class="progress-item">
          <div><strong>{{ $device->device ?: 'Unknown' }}</strong><span>{{ number_format($device->total) }} views · {{ $percent }}%</span></div>
          <em><i style="width: {{ $percent }}%"></i></em>
        </div>
      @empty
        <div class="empty">Belum ada data perangkat.</div>
      @endforelse
    </div>
  </div>
</div>

<div class="section-note">
  Data pengunjung mulai dihitung sejak revisi ini dipasang. Sistem menyimpan hash visitor/cookie, bukan IP asli. Pengunjung unik dihitung dari cookie browser.
</div>
@endsection
