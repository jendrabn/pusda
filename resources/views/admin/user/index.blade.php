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
          <table class="table table-striped table-bordered table-hover" id="dataTable">
            <thead>
              <tr>
                <th class="text-center">No</th>
                <th>Nama SKPD</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Email</th>
                <th>Level</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($users as $index => $user)
                <tr>
                  <td class="text-center">{{ ++$index }}</td>
                  <td>{{ $user->skpd->nama }}</td>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->username }}</td>
                  <td>{{ $user->email }}</td>
                  <td>{{ $user->role }}</td>
                  <td class="text-center">
                    <a href="{{ route('admin.users.show', $user->id) }}"
                      class="btn btn-icon btn-sm btn-info m-1 btn-detail">
                      <i class="fas fa-eye"></i>
                    </a>
                    <button data-url="{{ route('admin.users.destroy', $user->id) }}"
                      class="btn btn-icon btn-sm btn-danger m-1 btn-delete">
                      <i class="fas fa-trash-alt"></i>
                    </button>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-icon btn-sm btn-warning m-1">
                      <i class="fas fa-pencil-alt"></i>
                    </a>
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
@endsection

@push('scripts')
  <script>
    $(function() {

      $('.btn-delete').click(function() {
        Swal.fire({
          title: 'Hapus User ?',
          text: "Data yang dihapus tidak bisa dikembalikan!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Hapus',
          cancelButtonText: 'Batal',
        }).then((result) => {
          if (result.isConfirmed) {
            $('#form-delete').prop('action', $(this).data('url'))
            $('#form-delete').submit()
          }
        })
      })
    })
  </script>
@endpush
