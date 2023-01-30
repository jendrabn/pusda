@extends('layouts.admin', ['title' => 'Dashboard'])

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
  <section class="section-header">
    <h1>Dashboard</h1>
  </section>

  <section class="section-body">
    <div class="row">
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-info">
          <div class="card-body p-3">
            <div class="stat">
              <div class="display">
                <h2 class="number">0</h2>
                <div class="icon"><i class="fas fa-book text-info"></i></div>
              </div>
              <p class="title mb-2">ASSET ( DALAM MILYAR )</p>
              <div class="border-top pt-3">
                <div class="progress">
                  <div class="progress-bar bg-info" data-width="75%" role="progressbar" aria-valuenow="75"
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
                <h3 class="number">0</h3>
                <div class="icon"><i class="fas fa-layer-group text-danger"></i></div>
              </div>
              <p class="title mb-2">INVESTASI ( DALAM MILYAR )</p>
              <div class="border-top pt-3">
                <div class="progress">
                  <div class="progress-bar bg-danger" data-width="75%" role="progressbar" aria-valuenow="75"
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
                <h2 class="number">0</h2>
                <div class="icon"><i class="fas fa-briefcase text-warning"></i></div>
              </div>
              <p class="title mb-2">BARANG BARU</p>
              <div class="border-top pt-3">
                <div class="progress">
                  <div class="progress-bar bg-warning" data-width="75%" role="progressbar" aria-valuenow="75"
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
                <h2 class="number">{{ $countUser }}</h2>
                <div class="icon"><i class="fas fa-th-large text-success"></i></div>
              </div>
              <p class="title mb-2">PENGGUNA APLIKASI</p>
              <div class="border-top pt-3">
                <div class="progress">
                  <div class="progress-bar bg-success" data-width="75%" role="progressbar" aria-valuenow="75"
                    aria-valuemin="0" aria-valuemax="100">75%</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
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
