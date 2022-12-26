@extends('layouts.admin', ['title' => 'Users'])

@section('content')
  <div class="row"
       style="margin-bottom: 10px;">
    <div class="col-lg-12">
      <a class="btn btn-success"
         href="{{ route('admin.users.create') }}">
        Tambah User
      </a>
    </div>
  </div>

  <div class="card">
    <div class="card-header">
      Daftar User
    </div>
    <div class="card-body">
      <table class="table-bordered table-striped table-hover ajaxTable datatable datatable-User table">
        <thead>
          <tr>
            <th width="10"></th>
            <th>ID</th>
            <th>Name</th>
            <th>Username</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>SKPD</th>
            <th>Role</th>
            <th>Avatar</th>
            <th>&nbsp;</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
@endsection
@section('scripts')
  @parent
  <script>
    $(function() {
      let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

      let deleteButton = {
        text: 'Delete selected',
        url: "{{ route('admin.users.massDestroy') }}",
        className: 'btn-danger',
        action: function(e, dt, node, config) {
          var ids = $.map(dt.rows({
            selected: true
          }).data(), function(entry) {
            return entry.id
          });

          if (ids.length === 0) {
            alert('No rows selected')
            return
          }

          if (confirm('Are You Sure?')) {
            $.ajax({
                headers: {
                  'x-csrf-token': _token
                },
                method: 'POST',
                url: config.url,
                data: {
                  ids: ids,
                  _method: 'DELETE'
                }
              })
              .done(function() {
                location.reload()
              })
          }
        }
      }

      dtButtons.push(deleteButton)

      let dtOverrideGlobals = {
        buttons: dtButtons,
        processing: true,
        serverSide: true,
        retrieve: true,
        aaSorting: [],
        ajax: "{{ route('admin.users.index') }}",
        columns: [{
            data: 'placeholder',
            name: 'placeholder'
          },
          {
            data: 'id',
            name: 'id'
          },
          {
            data: 'name',
            name: 'name'
          },
          {
            data: 'username',
            name: 'username'
          },
          {
            data: 'email',
            name: 'email'
          },
          {
            data: 'phone',
            name: 'phone',
            visible: false
          },
          {
            data: 'address',
            name: 'address',
            visible: false
          },
          {
            data: 'skpd',
            name: 'skpd.nama',
          },
          {
            data: 'role',
            name: 'role'
          },
          {
            data: 'avatar',
            name: 'avatar',
            sortable: false,
            searchable: false,
            visible: false
          },
          {
            data: 'actions',
            name: 'Actions'
          }
        ],
        orderCellsTop: true,
        order: [
          [1, 'desc']
        ],
        pageLength: 50,
      };

      let table = $('.datatable-User').DataTable(dtOverrideGlobals);
      $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
        $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
      });

      let visibleColumnsIndexes = null;

      table.on('column-visibility.dt', function(e, settings, column, state) {
        visibleColumnsIndexes = []
        table.columns(":visible").every(function(colIdx) {
          visibleColumnsIndexes.push(colIdx);
        });
      });

    });
  </script>
@endsection
