@extends('layouts.admin', ['title' => 'Daftar SKPD'])

@section('content')
<div class="row" style="margin-bottom: 10px">
  <div class="col-lg-12">
    <a class="btn btn-success" href="{{ route('admin.skpd.create') }}">
      <i class="fas fa-plus"></i> Tambah SKPD
    </a>
  </div>
</div>
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Daftar SKPD</h3>
  </div>
  <div class="card-body">
    <table class="table-bordered table-striped table-hover ajaxTable datatable datatable-skpd table">
      <thead>
        <tr>
          <th width="10"></th>
          <th>&nbsp;</th>
          <th>ID</th>
          <th>Nama</th>
          <th>Singkatan</th>
          <th>Kategori</th>
        </tr>
      </thead>
    </table>
  </div>
</div>
@endsection

@section('scripts')
<script>
  $(function() {
    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);
    let deleteButtonText = "Delete selected";
    let deleteButton = {
      text: deleteButtonText,
      url: "{{ route('admin.skpd.massDestroy') }}",
      className: "btn-danger",
      action: function(e, dt, node, config) {
        var ids = $.map(
          dt
          .rows({
            selected: true,
          })
          .data(),
          function(entry) {
            return entry.id;
          }
        );

        if (ids.length === 0) {
          alert("No rows selected");

          return;
        }

        if (confirm("Are You Sure ?")) {
          $.ajax({
            headers: {
              "x-csrf-token": _token,
            },
            method: "POST",
            url: config.url,
            data: {
              ids: ids,
              _method: "DELETE",
            },
          }).done(function() {
            location.reload();
          });
        }
      },
    };
    dtButtons.push(deleteButton);

    let dtOverrideGlobals = {
      buttons: dtButtons,
      processing: true,
      serverSide: true,
      retrieve: true,
      aaSorting: [],
      ajax: "{{ route('admin.skpd.index') }}",
      columns: [{
          data: "placeholder",
          name: "placeholder"
        },
        {
          data: "actions",
          name: "actions",
        },
        {
          data: "id",
          name: "id",
        },
        {
          data: "nama",
          name: "nama",
        },
        {
          data: "singkatan",
          name: "singkatan",
        },
        {
          data: "kategori",
          name: "kategori.nama",
        },
      ],
      orderCellsTop: true,
      order: [
        [1, "desc"]
      ],
      pageLength: 100,
    };

    let table = $(".datatable-skpd").DataTable(dtOverrideGlobals);
    $('a[data-toggle="tab"]').on("shown.bs.tab click", function(e) {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
    });
  });
</script>
@endsection