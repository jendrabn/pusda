@extends('layouts.admin-master')

@section('title')
  SKPD
@endsection

@section('content')
  <div class="section-header">
    <h1>SKPD</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item">SKPD</div>
    </div>
  </div>
  <div class="section-body">
    @include('partials.alerts')

    <div class="row">
      <div class="col-12">
        <div class="card ">
          <div class="card-header">
            <h4>SKPD</h4>
            <div class="card-header-action">
              <a class="btn btn-primary btn-icon icon-left mr-2" data-toggle="modal" data-target="#modal-create">
                <i class="fas fa-plus"></i> Tambah SKPD
              </a>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              {{ $dataTable->table(['class' => 'table table-striped table-bordered w-100']) }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <form action="" id="form-delete" method="POST" hidden>@csrf @method('DELETE')</form>
@endsection

@section('outer')
  <div class="modal fade" tabindex="-1" role="dialog" id="modal-create">
    <div class="modal-dialog" role="document">
      <form action="{{ route('admin.skpd.store') }}" method="POST">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah SKPD</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="input-nama">Nama</label>
              <input type="text" class="form-control" id="input-nama" name="nama" tabindex="1" autofocus>
            </div>
            <div class="form-group">
              <label for="input-singkatan">Singkatan</label>
              <input type="text" class="form-control" name="singkatan" name="input-singkatan" tabindex="2">
            </div>
            <div class="form-group mb-0">
              <label for="input-kategori">Kategori</label>
              <select name="skpd_category_id" class="form-control select2" id="input-kategori" tabindex="3">
                <option value="none" disabled selected hidden>--Pilih Kategori--</option>
                @foreach ($categories as $id => $name)
                  <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary" tabindex="4">Simpan</button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection

@push('scripts')
  <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
  {{ $dataTable->scripts() }}
  <script>
    $(function() {
      const skpdsTable = window.LaravelDataTables['skpds-table'];

      $('#skpds-table').on('click', '.btn-delete', function(e) {
        const btn = $(this);
        Swal.fire({
          title: 'Ingin menghapus SKPD ?',
          text: 'Semua menu treeview dan uraian yang terkait dengan SKPD tersebut akan dihapus!',
          icon: 'warning',
          showCancelButton: true,
          cancelButtonColor: '#cdd3d8',
          confirmButtonColor: '#6777ef',
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
              beforeSend() {
                btn.addClass('btn-progress');
              },
              success: function(data) {
                skpdsTable.ajax.reload();
                Swal.fire('Dihapus!', data.message, 'success');
                btn.removeClass('btn-progress');
              },
              error: function(error) {
                const errorMessage = error.status + ': ' + error.statusText;
                Swal.fire('Gagal!', errorMessage, 'error');
                btn.removeClass('btn-progress');
              }
            });
          }
        });
      });
    });
  </script>
@endpush
