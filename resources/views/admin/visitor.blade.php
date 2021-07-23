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
          <table class="table table-striped table-bordered table-hover" id="dataTable">
            <thead>
              <tr>
                <th class="text-center">No</th>
                <th>Alamat IP</th>
                <th>Sistem Operasi</th>
                <th>Waktu</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($visitors as $index => $visitor)
                <tr>
                  <td class="text-center">{{ ++$index }}</td>
                  <td>{{ $visitor->ip }}</td>
                  <td>{{ $visitor->os }}</td>
                  <td>{{ $visitor->created_at }}</td>
                  <td class="text-center">
                    <button data-url="{{ route('admin.visitor.destroy', $visitor->id) }}"
                      class="btn btn-icon btn-sm btn-danger m-1 btn-delete"><i class="fas fa-trash-alt"></i>
                    </button>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <form action="" id="form-delete" method="POST" hidden>@csrf @method('DELETE')</form>
  <form action="" id="form-deleteall" method="POST" hidden>@csrf @method('DELETE')</form>
@endsection

@push('scripts')

  <script>
    $(function() {
      $('.btn-delete').click(function() {
        $('#form-delete').prop('action', $(this).data('url'))
        $('#form-delete').submit()
      })

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
