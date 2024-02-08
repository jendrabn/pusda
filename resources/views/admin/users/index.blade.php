@extends('layouts.admin', ['title' => 'Users'])

@section('content')
  <div class="row"
    style="margin-bottom: 10px">
    <div class="col-lg-12">
      <a class="btn btn-success btn-flat"
        href="{{ route('admin.users.create') }}">
        <i class="fas fa-plus mr-1"></i> Tambah User
      </a>
    </div>
  </div>

  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Daftar User</h3>
    </div>
    <div class="card-body">
      <table class="table-bordered table-striped table-hover ajaxTable datatable datatable-User table table-sm">
        <thead>
          <tr>
            <th width="10"></th>
            <th>ID</th>
            <th>Name</th>
            <th>Username</th>
            <th>Email</th>
            <th>SKPD</th>
            <th>Role</th>
            <th style="min-width: 100px;">&nbsp;</th>
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
        url: "{{ route('admin.users.massDestroy') }}",
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

          if (confirm("Are You Sure?")) {
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
        ajax: "{{ route('admin.users.index') }}",
        columns: [{
            data: "placeholder",
            name: "placeholder",
          },

          {
            data: "id",
            name: "id",
          },
          {
            data: "name",
            name: "name",
          },
          {
            data: "username",
            name: "username",
          },
          {
            data: "email",
            name: "email",
          },
          {
            data: "skpd.nama",
            name: "skpd.nama",
          },
          {
            data: "role",
            name: "role",
          },
          {
            data: "actions",
            name: "actions",
          },
        ],
        orderCellsTop: true,
        order: [
          [1, "desc"]
        ],
        pageLength: 50,
      };

      let table = $(".datatable-User").DataTable(dtOverrideGlobals);
      $('a[data-toggle="tab"]').on("shown.bs.tab click", function(e) {
        $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
      });

    });
  </script>
@endsection
