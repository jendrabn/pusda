@extends('layouts.admin-master')

@section('title')
  Log User
@endsection

@section('content')
  <div class="section-header">
    <h1>Log User</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">User</a></div>
      <div class="breadcrumb-item">Log User</div>
    </div>
  </div>
  <div class="section-body">
    @include('partials.alerts')

    <div class="card">
      <div class="card-header">
        <h4>Log User</h4>
        <div class="card-header-action">
          <button data-url="{{ route('admin.userlog.destroyall') }}" class="btn btn-icon icon-left btn-danger"
            id="btn-delete"><i class="fas fa-trash-alt"></i> Hapus
            Semua Log</button>
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
      const userLogsTable = window.LaravelDataTables['userlogs-table'];

      $('button#btn-delete').on('click', function(e) {
        const btn = $(this);
        Swal.fire({
          title: 'Ingin menghapus semua User Logs?',
          text: 'Semua user logs yang sudah dihapus tidak bisa dikembalikan!',
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
                userLogsTable.ajax.reload();
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
