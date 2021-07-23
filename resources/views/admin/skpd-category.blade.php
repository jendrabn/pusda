@extends('layouts.admin-master')

@section('title')
  Kategori SKPD
@endsection

@section('content')
  <section class="section-header">
    <h1>Kategori SKPD</h1>
  </section>

  <section class="section-body">
    <div class="row">
      <div class="col-12">
        @include('partials.alerts')
        <div class="card">
          <div class="card-header">
            <h4>Kategori SKPD</h4>
            <div class="card-header-action">
              <button id="btn-add-category" class="btn btn-icon icon-left btn-primary"><i class="fas fa-plus"></i> Tambah
                Kategori</button>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover" id="dataTable">
                <thead>
                  <th class="text-center">No</th>
                  <th>Nama Kategori</th>
                  <th>Jumlah SKPD</th>
                  <th class="text-center">Aksi</th>
                </thead>
                <tbody>
                  @foreach ($categories as $index => $category)
                    <tr>
                      <td class="text-center">{{ ++$index }}</td>
                      <td>{{ $category->name }}</td>
                      <td>{{ $category->skpd->count() }}</td>
                      <td class="text-center">
                        <button data-url="{{ route('admin.skpd_category.destroy', $category->id) }}"
                          class="btn btn-icon btn-sm btn-danger m-1 btn-delete"><i class="fas fa-trash-alt"></i>
                        </button>
                        <button data-url="{{ route('admin.skpd_category.update', $category->id) }}"
                          data-name="{{ $category->name }}" class="btn btn-icon btn-sm btn-warning m-1 btn-edit"><i
                            class="fas fa-pencil-alt"></i>
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
    </div>

    <form action="" id="form-delete" method="POST" hidden>@csrf @method('DELETE')</form>
  </section>
@endsection

@section('outer')
  <div class="modal fade" id="modal-add-category" tabindex="-1" aria-labelledby="modalAddCategory" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalAddCategory">Tambah Kategori SKPD</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('admin.skpd_category.store') }}" method="POST">
            @csrf
            <div class="form-group">
              <label>Nama Kategori</label>
              <input type="text" name="name" class="form-control" autofocus>
            </div>
            <div class="form-group text-right mb-0">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal-edit-category" tabindex="-1" aria-labelledby="modalEditCategory" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalEditCategory">Edit Kategori SKPD</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('admin.skpd_category.store') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
              <label>Nama Kategori</label>
              <input type="text" name="name" class="form-control" autofocus>
            </div>
            <div class="form-group text-right mb-0">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection


@push('scripts')
  <script>
    $(function() {

      const isOpen = (new URLSearchParams(window.location.search)).get('modal-add')
      if (isOpen === 'open') {
        $('#modal-add-category').modal('show')
      }

      $('#btn-add-category').on('click', function() {
        $('#modal-add-category').modal('show')
      })

      $('#modal-add-category').on('hidden.bs.modal', function(event) {
        $('#modal-add-category input[name=name]').val('')
      })

      $('.btn-edit').on('click', function() {
        $('#modal-edit-category form').prop('action', $(this).data('url'))
        $('#modal-edit-category input[name=name]').val($(this).data('name'))
        $('#modal-edit-category').modal('show')
      })

      $('.btn-delete').on('click', function() {
        $('#form-delete').prop('action', $(this).data('url'))
        Swal.fire({
          title: 'Hapus kategori SKPD ?',
          text: "Data yang dihapus tidak bisa dikembalikan!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Hapus',
          cancelButtonText: 'Batal',
        }).then((result) => {
          if (result.isConfirmed) {
            $('#form-delete').submit()
          }
        })
      })
    })
  </script>
@endpush
