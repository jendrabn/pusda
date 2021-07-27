@extends('layouts.admin-master')

@section('title')
  Data SKPD
@endsection

@section('content')
  <div class="section-header">
    <h1>Data SKPD</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item">Data SKPD</div>
    </div>
  </div>
  <div class="section-body">
    <div class="row">
      <div class="col-12">
        @include('partials.alerts')
        <div class="card ">
          <div class="card-header">
            <h4>Data SKPD</h4>
            <div class="card-header-action">
              <a class="btn btn-primary btn-icon icon-left mr-2" data-toggle="modal" data-target="#modal-create">
                <i class="fas fa-plus"></i> Tambah SKPD
              </a>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover" id="dataTable">
                <thead>
                  <tr>
                    <th class="text-center">No</th>
                    <th>Nama</th>
                    <th>Singkatan</th>
                    <th>Kategori</th>
                    <th class="text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($skpd as $index => $skpd)
                    <tr>
                      <td class="text-center">{{ ++$index }}</td>
                      <td>{{ $skpd->nama }}</td>
                      <td>{{ $skpd->singkatan }}</td>
                      <td>{{ $skpd->skpdCategory->name ?? '' }}</td>
                      <td class="text-center">
                        @if ($skpd->skpdCategory)
                          <button data-url="{{ route('admin.skpd.destroy', $skpd->id) }}"
                            class="btn btn-icon btn-sm btn-danger m-1 btn-delete"><i class="fas fa-trash-alt"></i>
                          </button>
                          <a href="{{ route('admin.skpd.edit', $skpd->id) }}"
                            class="btn btn-icon btn-sm btn-warning m-1 btn-edit"><i class="fas fa-pencil-alt"></i>
                          </a>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
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
              <input type="text" class="form-control" id="input-nama" name="nama" value="{{ request()->old('name') }}">
            </div>
            <div class="form-group">
              <label for="input-singkatan">Singkatan</label>
              <input type="text" class="form-control" name="singkatan" name="input-singkatan"
                value="{{ request()->old('name') }}">
            </div>
            <div class="form-group mb-0">
              <label for="input-kategori">Kategori</label>
              <select name="skpd_category_id" class="form-control" id="input-kategori">
                <option value="none" disabled selected hidden>--Pilih Kategori--</option>
                @foreach ($categories as $id => $name)
                  <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    $(function() {
      $('.btn-delete').click(function() {
        Swal.fire({
          title: 'Hapus Data SKPD ?',
          text: 'Data yang sudah dihapus tidak bisa dikembalikan!',
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
