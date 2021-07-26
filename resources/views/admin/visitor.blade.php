@extends('layouts.admin-master')

@section('title')
  Pengunjung
@endsection

@section('content')
  <div class="section-header">
    <h1>Pengunjung</h1>
  </div>

  <div class="section-body">
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
          <button class="btn btn-icon icon-left btn-danger" id="btn-deleteall"><i class="fas fa-trash-alt"></i> Hapus
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
  <form action="" id="form-deleteall" method="POST" hidden>@csrf @method('DELETE')</form>
@endsection

@push('scripts')
  <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
  {{ $dataTable->scripts() }}
  <script>
    $(function() {
      $('#btn-deleteall').click(function() {
        Swal.fire({
          title: 'Hapus semua data Pengunjung ?',
          text: "Data yang dihapus tidak bisa dikembalikan!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Hapus',
          cancelButtonText: 'Batal',
        }).then((result) => {
          if (result.isConfirmed) {
            $('#form-deleteall').submit()
          }
        })
      })
    })
  </script>
@endpush
