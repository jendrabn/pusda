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
            Semua Data</button>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered" id="dataTable">
            <thead>
              <tr>
                <th class="text-center">No</th>
                <th>Nama</th>
                <th>SKPD</th>
                <th>Tipe</th>
                <th>Waktu</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($userLogs as $index => $log)
                <tr>
                  <td class="text-center">{{ ++$index }}</td>
                  <td>{{ $log->user->name }} <span class="text-danger">[{{ $log->user->role }}]</span> </td>
                  <td>{{ $log->user->skpd->singkatan }}</td>
                  <td>{!! $log->type !!}</td>
                  <td>{{ $log->created_at->diffForHumans() }}</td>
                  <td class="text-center">
                    <button data-url="{{ route('admin.userlog.destroy', $log->id) }}"
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
  <form action="{{ route('admin.userlog.destroyall') }}" id="form-deleteall" method="POST" hidden>@csrf
    @method('DELETE')
  </form>
@endsection

@push('scripts')
  <script>
    $(function() {
      $('#dataTable').on('click', 'tbody .btn-delete', function() {
        $('#form-delete').prop('action', $(this).data('url'))
        $('#form-delete').submit()
      })

      $('#btn-deleteall').click(function() {
        Swal.fire({
          title: 'Hapus semua log user login ?',
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
