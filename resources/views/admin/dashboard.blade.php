@extends('layouts.admin-master')

@section('title')
  Dashboard
@endsection

@push('styles')
  <style>
    .stat .display {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;

    }

    .stat .display .number {
      margin-bottom: 0;
    }

    .stat .title {
      font-size: .8rem;
      margin-top: 7px;
    }

    .stat .display .icon i {
      color: #cbd4e0;
      font-size: 26px;
    }

  </style>
@endpush


@section('content')
  <div class="section-header">
    <h1>Dashboard</h1>
  </div>

  <div class="section-body">
    <div class="row">
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-info">
          <div class="card-body p-3">
            <div class="stat">
              <div class="display">
                <h2 class="number">{{ $info->total_8keldata }}</h2>
                <div class="icon"><i class="fas fa-book text-info"></i></div>
              </div>
              <p class="title mb-2">JUMLAH DATA 8 KEL. DATA</p>
              <div class="pt-3 border-top">
                <div class="progress">
                  <div class="progress-bar bg-info" role="progressbar" data-width="75%" aria-valuenow="75"
                    aria-valuemin="0" aria-valuemax="100">75%</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-danger">
          <div class="card-body p-3">
            <div class="stat">
              <div class="display">
                <h2 class="number">{{ $info->total_indikator }}</h2>
                <div class="icon"><i class="fas fa-layer-group text-danger"></i></div>
              </div>
              <p class="title mb-2">JUMLAH DATA INDIKATOR</p>
              <div class="pt-3 border-top">
                <div class="progress">
                  <div class="progress-bar bg-danger" role="progressbar" data-width="75%" aria-valuenow="75"
                    aria-valuemin="0" aria-valuemax="100">75%</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-warning">
          <div class="card-body p-3">
            <div class="stat">
              <div class="display">
                <h2 class="number">{{ $info->total_rpjmd }}</h2>
                <div class="icon"><i class="fas fa-briefcase text-warning"></i></div>
              </div>
              <p class="title mb-2">JUMLAH DATA RPJMD</p>
              <div class="pt-3 border-top">
                <div class="progress">
                  <div class="progress-bar bg-warning" role="progressbar" data-width="75%" aria-valuenow="75"
                    aria-valuemin="0" aria-valuemax="100">75%</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-success">
          <div class="card-body p-3">
            <div class="stat">
              <div class="display">
                <h2 class="number">{{ $info->total_bps }}</h2>
                <div class="icon"><i class="fas fa-th-large text-success"></i></div>
              </div>
              <p class="title mb-2">JUMLAH DATA BPS</p>
              <div class="pt-3 border-top">
                <div class="progress">
                  <div class="progress-bar bg-success" role="progressbar" data-width="75%" aria-valuenow="75"
                    aria-valuemin="0" aria-valuemax="100">75%</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <h4>Aktivitas Terbaru</h4>
            <div class="card-header-action">
              <a href="{{ route('admin.userlog.index') }}" class="btn btn-danger">Lihat Selengkapnya <i
                  class="fas fa-chevron-right"></i></a>
            </div>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive table-invoice">
              <table class="table table-striped">
                <tr>
                  <th>#</th>
                  <th>Nama</th>
                  <th>Level</th>
                  <th>Tipe</th>
                  <th>Waktu</th>
                </tr>
                @foreach ($userLogs as $index => $log)
                  <tr>
                    <td>{{ ++$index }}</td>
                    <td class="font-weight-600">{{ $log->user->name }}</td>
                    <td>
                      @if ($log->user->level === 1)
                        <div class="badge badge-info">{{ $log->user->role }}</div>
                      @endif
                      @if ($log->user->level === 2)
                        <div class="badge badge-warning">{{ $log->user->role }}</div>
                      @endif
                    </td>
                    <td>{{ $log->type }}</td>
                    <td>
                      {{ $log->created_at->diffForHumans() }}
                    </td>
                  </tr>
                @endforeach
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    $(function() {
      $('.number').each(function() {
        var $this = $(this);
        jQuery({
          Counter: 0
        }).animate({
          Counter: $this.text()
        }, {
          duration: 1000,
          easing: 'swing',
          step: function() {
            $this.text(Math.ceil(this.Counter));
          }
        });
      });
    });
  </script>
@endpush
