@extends('layouts.admin', ['title' => 'Dashboard'])

@section('content')
  <!-- SKPD Identity -->
  <div class="row">
    <div class="col-lg-12">
      <div class="card bg-gradient-navy">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h4 class="mb-0"><i class="fas fa-building mr-2"></i>{{ $skpd->nama ?? 'SKPD' }}</h4>
              <small class="opacity-7">{{ $skpd->kategori->nama ?? '-' }} &middot; {{ $skpd->singkatan ?? '' }}</small>
            </div>
            <div class="text-right">
              <h5 class="mb-0">{{ $usersSkpd }}</h5>
              <small>Anggota SKPD</small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Stats Cards Row -->
  <div class="row">
    <div class="col-lg-3 col-6">
      <div class="small-box bg-info">
        <div class="inner">
          <h3>{{ $totalTabel }}</h3>
          <p>MENU / TABEL</p>
        </div>
        <div class="icon">
          <i class="fas fa-sitemap"></i>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-6">
      <div class="small-box bg-success">
        <div class="inner">
          <h3>{{ number_format($totalUraian, 0, ',', '.') }}</h3>
          <p>TOTAL URAIAN</p>
        </div>
        <div class="icon">
          <i class="fas fa-list"></i>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-6">
      <div class="small-box bg-warning">
        <div class="inner">
          <h3>{{ number_format($totalIsi, 0, ',', '.') }}</h3>
          <p>ISI DATA</p>
        </div>
        <div class="icon">
          <i class="fas fa-database"></i>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-6">
      <div class="small-box bg-danger">
        <div class="inner">
          <h3>{{ number_format($totalFiles, 0, ',', '.') }}</h3>
          <p>FILE PENDUKUNG</p>
        </div>
        <div class="icon">
          <i class="fas fa-file"></i>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-6">
      <div class="small-box bg-primary">
        <div class="inner">
          <h3>{{ $totalTabel8kel }}</h3>
          <p>TABEL 8 KEL. DATA</p>
        </div>
        <div class="icon">
          <i class="fas fa-chart-pie"></i>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-6">
      <div class="small-box bg-secondary">
        <div class="inner">
          <h3>{{ $totalTabelRpjmd }}</h3>
          <p>TABEL RPJMD</p>
        </div>
        <div class="icon">
          <i class="fas fa-clipboard-list"></i>
        </div>
      </div>
    </div>
  </div>

  <!-- Ketersediaan Data & Detail Stats -->
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title">Rincian Data</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-3 col-6">
              <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-chart-pie"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">8 Kel. Data</span>
                  <span class="info-box-number">{{ number_format($totalUraian8kel, 0, ',', '.') }}
                    <small>Uraian</small></span>
                </div>
              </div>
            </div>
            <div class="col-md-3 col-6">
              <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fas fa-clipboard-list"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">RPJMD</span>
                  <span class="info-box-number">{{ number_format($totalUraianRpjmd, 0, ',', '.') }}
                    <small>Uraian</small></span>
                </div>
              </div>
            </div>
            <div class="col-md-3 col-6">
              <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fas fa-chart-line"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Indikator</span>
                  <span class="info-box-number">{{ number_format($totalUraianIndikator, 0, ',', '.') }}
                    <small>Uraian</small></span>
                </div>
              </div>
            </div>
            <div class="col-md-3 col-6">
              <div class="info-box">
                <span class="info-box-icon bg-danger"><i class="fas fa-globe"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">BPS</span>
                  <span class="info-box-number">{{ number_format($totalUraianBps, 0, ',', '.') }}
                    <small>Uraian</small></span>
                </div>
              </div>
            </div>
          </div>
          @if ($ketersediaanTotal > 0)
            <div class="row mt-3">
              <div class="col-md-12">
                <p class="mb-1"><strong>Ketersediaan Data (8 Kel. Data & RPJMD)</strong></p>
                <div class="progress progress-xl">
                  <div class="progress-bar bg-success progress-bar-striped" role="progressbar"
                    style="width: {{ $ketersediaanPersen }}%" aria-valuenow="{{ $ketersediaanPersen }}"
                    aria-valuemin="0" aria-valuemax="100">
                    {{ $ketersediaanPersen }}% Tersedia
                  </div>
                  <div class="progress-bar bg-danger" role="progressbar"
                    style="width: {{ 100 - $ketersediaanPersen }}%"
                    aria-valuenow="{{ 100 - $ketersediaanPersen }}" aria-valuemin="0" aria-valuemax="100">
                    {{ 100 - $ketersediaanPersen }}% Tidak Tersedia
                  </div>
                </div>
                <small class="text-muted">{{ $ketersediaanTersedia }} dari {{ $ketersediaanTotal }} uraian tersedia</small>
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>

  <!-- Charts Row -->
  <div class="row">
    <div class="col-md-8">
      <div class="card card-outline">
        <div class="card-header">
          <h5 class="card-title">Tren Data per Tahun</h5>
        </div>
        <div class="card-body">
          <canvas id="lineChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card card-outline">
        <div class="card-header">
          <h5 class="card-title">Komposisi Uraian</h5>
        </div>
        <div class="card-body">
          <canvas id="pieChart" style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
        </div>
      </div>
    </div>
  </div>

  <!-- Table Summary & Recent Activity -->
  <div class="row">
    <div class="col-md-7">
      <div class="card card-outline">
        <div class="card-header">
          <h5 class="card-title">Ringkasan Data per Menu</h5>
        </div>
        <div class="card-body p-0">
          <table class="table table-hover table-striped m-0">
            <thead>
              <tr>
                <th>Menu</th>
                <th>Tipe</th>
                <th class="text-right">Uraian</th>
                <th class="text-right">Isi</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($tabelSummaries as $s)
                <tr>
                  <td>{{ $s['nama'] }}</td>
                  <td><span class="badge badge-{{ $s['tipe'] == '8 Kel. Data' ? 'info' : 'success' }}">{{ $s['tipe'] }}</span></td>
                  <td class="text-right">{{ number_format($s['uraian'], 0, ',', '.') }}</td>
                  <td class="text-right">{{ number_format($s['isi'], 0, ',', '.') }}</td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="text-center">Belum ada data</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-md-5">
      <div class="card card-outline">
        <div class="card-header">
          <h5 class="card-title">Aktivitas Terbaru</h5>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover m-0">
              <thead>
                <tr>
                  <th>User</th>
                  <th>Aktivitas</th>
                  <th>Waktu</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($recentLogs as $log)
                  <tr>
                    <td>{{ $log->user ? $log->user->name : '-' }}</td>
                    <td>{{ Str::limit($log->description, 40) }}</td>
                    <td><small class="text-muted">{{ $log->created_at->diffForHumans() }}</small></td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="3" class="text-center">Belum ada aktivitas</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Quick Actions -->
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title">Aksi Cepat</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <a href="{{ route('admin_skpd.delapankeldata.index') }}" class="col-md-3 col-6 text-reset" style="text-decoration: none;">
              <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-chart-pie"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">8 Kel. Data</span>
                </div>
              </div>
            </a>
            <a href="{{ route('admin_skpd.rpjmd.index') }}" class="col-md-3 col-6 text-reset" style="text-decoration: none;">
              <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fas fa-clipboard-list"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">RPJMD</span>
                </div>
              </div>
            </a>
            <a href="{{ route('profile') }}" class="col-md-3 col-6 text-reset" style="text-decoration: none;">
              <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fas fa-user-cog"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Profil Saya</span>
                </div>
              </div>
            </a>
            <a href="{{ route('admin_skpd.rpjmd.index') }}" class="col-md-3 col-6 text-reset" style="text-decoration: none;">
              <div class="info-box">
                <span class="info-box-icon bg-danger"><i class="fas fa-upload"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Input RPJMD</span>
                </div>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  @parent
  <script>
    $(function() {
      var years = @json($chartYears);
      var data8kel = @json($chart8kel);
      var dataRpjmd = @json($chartRpjmd);
      var dataIndikator = @json($chartIndikator);
      var dataBps = @json($chartBps);

      var areaChartCanvas = $('#lineChart').get(0).getContext('2d');
      new Chart(areaChartCanvas, {
        type: 'line',
        data: {
          labels: years,
          datasets: [{
            label: '8 Kel. Data',
            data: data8kel,
            backgroundColor: 'rgba(23, 162, 184, 0.2)',
            borderColor: 'rgba(23, 162, 184, 1)',
            pointRadius: 4,
            pointHoverRadius: 6,
            fill: true,
            tension: 0.3
          }, {
            label: 'RPJMD',
            data: dataRpjmd,
            backgroundColor: 'rgba(40, 167, 69, 0.2)',
            borderColor: 'rgba(40, 167, 69, 1)',
            pointRadius: 4,
            pointHoverRadius: 6,
            fill: true,
            tension: 0.3
          }, {
            label: 'Indikator',
            data: dataIndikator,
            backgroundColor: 'rgba(255, 193, 7, 0.2)',
            borderColor: 'rgba(255, 193, 7, 1)',
            pointRadius: 4,
            pointHoverRadius: 6,
            fill: true,
            tension: 0.3
          }, {
            label: 'BPS',
            data: dataBps,
            backgroundColor: 'rgba(220, 53, 69, 0.2)',
            borderColor: 'rgba(220, 53, 69, 1)',
            pointRadius: 4,
            pointHoverRadius: 6,
            fill: true,
            tension: 0.3
          }]
        },
        options: {
          maintainAspectRatio: false,
          responsive: true,
          plugins: {
            legend: {
              position: 'top'
            }
          },
          scales: {
            x: {
              ticks: { autoSkip: true, maxTicksLimit: 12 }
            },
            y: {
              beginAtZero: true,
              ticks: { precision: 0 }
            }
          }
        }
      });

      var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
      new Chart(pieChartCanvas, {
        type: 'doughnut',
        data: {
          labels: ['8 Kel. Data', 'RPJMD', 'Indikator', 'BPS'],
          datasets: [{
            data: [
              {{ $totalUraian8kel }},
              {{ $totalUraianRpjmd }},
              {{ $totalUraianIndikator }},
              {{ $totalUraianBps }}
            ],
            backgroundColor: ['#17a2b8', '#28a745', '#ffc107', '#dc3545'],
            hoverOffset: 8
          }]
        },
        options: {
          maintainAspectRatio: false,
          responsive: true,
          plugins: {
            legend: {
              position: 'bottom'
            }
          }
        }
      });
    });
  </script>
@endsection
