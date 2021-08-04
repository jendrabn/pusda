@extends('layouts.admin-master')

@section('title')
  User
@endsection

@section('content')
  <div class="section-header">
    <h1>User</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item"> User</div>
    </div>
  </div>
  <div class="section-body">
    @include('partials.alerts')

    <div class="card ">
      <div class="card-header">
        <h4>User</h4>
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
        const btn = $(this);
        Swal.fire({
          title: 'Ingin menghapus User?',
          text: 'User yang sudah dihapus tidak bisa dikembalikan!',
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
                usersTable.ajax.reload();
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
    })
  </script>
@endpush
