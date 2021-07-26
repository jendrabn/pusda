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
      <div class="breadcrumb-item"> Log User</div>
    </div>
  </div>
  <div class="section-body">
    @include('partials.alerts')
    <div class="card">
      <div class="card-header">
        <h4>Log User</h4>
        <div class="card-header-action">
          <button class="btn btn-icon icon-left btn-danger" id="btn-deleteall"><i class="fas fa-trash-alt"></i> Hapus
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

  <form action="" id="form-delete" method="POST" hidden>@csrf @method('DELETE')</form>
  <form action="{{ route('admin.userlog.destroyall') }}" id="form-deleteall" method="POST" hidden>@csrf
    @method('DELETE')
  </form>
@endsection

@push('scripts')
  <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
  {{ $dataTable->scripts() }}
  <script>
    $(function() {
      $('#btn-deleteall').click(function() {
        Swal.fire({
          title: 'Hapus semua log user?',
          text: 'Data yang sudah dihapus tidak bisa dikembalikan!',
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
