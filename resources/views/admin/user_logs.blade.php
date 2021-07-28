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
    <h2 class="section-title">Log User</h2>
    <p class="section-lead">
      Lorem ipsum dolor sit amet consectetur adipisicing elit. Similique aspernatur possimus consequatur neque quam
      ducimus?
    </p>
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
        Swal.fire({
          title: 'Apakah kamu yakin?',
          text: 'Semua data user logs yang sudah dihapus tidak bisa dikembalikan!',
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
                userLogsTable.ajax.reload();
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
