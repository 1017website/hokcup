@extends('admin.layout')
@section('title','Artisan Command')
@section('page_title','Artisan Command')
@section('page_description','Jalankan perintah maintenance Laravel langsung dari CMS: migrate, optimize:clear, dan storage:link.')
@section('page_action')
  <form method="POST" action="{{ route('admin.commands.run') }}" onsubmit="return confirm('Jalankan semua command: migrate, storage:link, dan optimize:clear?')">
    @csrf
    <input type="hidden" name="command" value="all">
    <button class="btn btn-primary" type="submit"><i class="fas fa-play"></i> Jalankan Semua</button>
  </form>
@endsection
@section('content')
<div class="section-note" style="margin-bottom:18px">
  <strong>Catatan penting:</strong> halaman ini dibuat agar admin bisa menjalankan command Laravel tanpa SSH. Gunakan seperlunya, terutama setelah update file revisi CMS. Untuk production, pastikan database sudah dibackup sebelum menjalankan <code>php artisan migrate</code>.
</div>

<div class="grid grid-3 command-grid">
  @foreach($commands as $key => $command)
    <div class="card command-card">
      <div class="command-icon"><i class="fas {{ $command['icon'] }}"></i></div>
      <h3>{{ $command['label'] }}</h3>
      <p class="help">{{ $command['description'] }}</p>
      <div class="command-warning"><i class="fas fa-circle-info"></i> {{ $command['warning'] }}</div>
      <form method="POST" action="{{ route('admin.commands.run') }}" onsubmit="return confirm('Jalankan {{ $command['label'] }} sekarang?')">
        @csrf
        <input type="hidden" name="command" value="{{ $key }}">
        <button class="btn btn-dark" type="submit"><i class="fas fa-terminal"></i> Jalankan</button>
      </form>
    </div>
  @endforeach
</div>

@if(session('command_results'))
  <div class="card command-output-card">
    <div class="card-head-inline">
      <h3>Hasil Command</h3>
      <span class="pill">{{ count(session('command_results')) }} command</span>
    </div>

    <div class="terminal-output">
      @foreach(session('command_results') as $result)
        <div class="command-result {{ $result['status'] === 'success' ? 'is-success' : 'is-failed' }}">
          <div class="command-result-head">
            <strong>$ {{ $result['label'] }}</strong>
            <span>{{ $result['status'] === 'success' ? 'Berhasil' : 'Gagal' }} · Exit Code {{ $result['exit_code'] }}</span>
          </div>
          <pre>{{ $result['output'] }}</pre>
        </div>
      @endforeach
    </div>
  </div>
@endif
@endsection
