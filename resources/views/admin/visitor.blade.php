@extends('layouts.admin-master')

@section('title')
  Pengunjung
@endsection

@section('content')
  <div class="section-header">
    <h1>Pengunjung</h1>
  </div>

  <div class="section-body">
    <h2 class="section-title">Pengujung</h2>
    <p class="section-lead">
      Lorem ipsum dolor sit amet consectetur adipisicing elit. Error dignissimos reiciendis odit? Odit, reprehenderit
      voluptatem.
    </p>
    <div class="row">
      <div class="col-lg-3">
        <div class="card">
          <div class="card-body d-flex justify-content-between">
            <p class="mb-0">Hari Ini</p>
            <h5>{{ $statistic->day_count }}</h5>
          </div>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="card">
          <div class="card-body d-flex justify-content-between">
            <p class="mb-0">Minggu Ini</p>
            <h5>{{ $statistic->week_count }}</h5>
          </div>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="card">
          <div class="card-body d-flex justify-content-between">
            <p class="mb-0">Bulan Ini</p>
            <h5>{{ $statistic->month_count }}</h5>
          </div>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="card">
          <div class="card-body d-flex justify-content-between">
            <p class="mb-0">Semua</p>
            <h5>{{ $statistic->all_count }}</h5>
          </div>
        </div>
      </div>
    </div>

    @include('partials.alerts')
    <div class="card">
      <div class="card-header">
        <h4>Pengunjung</h4>
        <div class="card-header-action">
          <button data-url="{{ route('admin.visitor.destroyall') }}" class="btn btn-icon icon-left btn-danger"
            id="btn-delete"><i class="fas fa-trash-alt"></i> Hapus
            Semua Data</button>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          {{ $dataTable->table(['class' => 'table table-striped table-bordered w-100']) }}
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
  {{ $dataTable->scripts() }}
  <script>
    $(function() {
      const statisticsTable = window.LaravelDataTables['statistics-table'];

      $('button#btn-delete').on('click', function(e) {
        Swal.fire({
          title: 'Apakah kamu yakin?',
          text: 'Semua data pengunjung yang sudah dihapus tidak bisa dikembalikan!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#fc544b',
          cancelButtonColor: '#3490dc',
          confirmButtonText: 'Hapus',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: $(this).data('url'),
              type: 'DELETE',
              dataType: 'json',
              data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
              },
              success: function(data) {
                statisticsTable.ajax.reload();
                Swal.fire('Dihapus!', data.message, 'success');
              },
              error: function(error) {
                Swal.fire('Gagal!', error.statusText, 'error');
              }
            });
          }
        });
      });
    });
  </script>
@endpush
