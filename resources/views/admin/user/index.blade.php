@extends('layouts.admin-master')

@section('title')
  Data User
@endsection

@section('content')
  <div class="section-header">
    <h1>Data User</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item">Data User</div>
    </div>
  </div>
  <div class="section-body">
    @include('partials.alerts')
    <div class="card ">
      <div class="card-header">
        <h4>Data User</h4>
        <div class="card-header-action">
          <a class="btn btn-icon icon-left btn-primary" href="{{ route('admin.users.create') }}"><i
              class="fas fa-plus"></i> Tambah User</a>
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
      const usersTable = window.LaravelDataTables['users-table'];

      $('#users-table tbody').on('click', '.btn-delete', function(e) {
        Swal.fire({
          title: 'Apakah kamu yakin?',
          text: 'Pengguna yang sudah dihapus tidak bisa dikembalikan!',
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
                usersTable.ajax.reload();
                Swal.fire('Dihapus!', data.message, 'success');
              },
              error: function(error) {
                Swal.fire('Gagal!', error.statusText, 'error');
              }
            });
          }
        });
      });
    })
  </script>
@endpush
