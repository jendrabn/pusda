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
                <th>Name</th>
                <th>SKPD</th>
                <th>Tipe</th>
                <th>Waktu</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
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
    $(document).ready(function() {
      isi()
    })
    function isi() {
      $('#dataTable').DataTable({
        serverside : true,
        responsive : true,
        "bDestroy": true,
        ajax : {
          url : "{{route('admin.userlog.index')}}"
        },
        columns:[
          {
            "data" : null, "sortable": false,
            render : function (data, type, row, meta){
              return meta.row + meta.settings._iDisplayStart + 1
            }
          },
          {data: 'name', name:'name'},
          {data: 'SKPD', name:'SKPD'},
          {data: 'type', name:'type'},
          {data: 'created_at', name:'created_at'},
          {data: 'aksi', name: 'aksi'}
          ]
      })
    }
    $(document).on('click', '.btn-delete', function () {
     
    var id = $(this).attr('id');
     $.ajax({
       type: 'DELETE',
      url: "{{ url('admin/userlog/delete' ) }}"+'/'+ id,
      data: {"_token": '{{csrf_token()}}' },
         success: function () {
             $('#dataTable').DataTable().ajax.reload()
         }
     });
 });

    $(function() {
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
