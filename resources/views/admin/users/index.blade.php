@extends('layouts.admin', ['title' => 'Users'])

@section('content')
  <div class="row" style="margin-bottom: 10px;">
    <div class="col-lg-12">
      <a class="btn btn-success" href="{{ route('admin.users.create') }}">
        <i class="fas fa-plus"></i> Tambah User
      </a>
    </div>
  </div>

  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Daftar User</h3>
    </div>
    <div class="card-body">
      <table class="table-bordered table-striped table-hover ajaxTable datatable datatable-User table">
        <thead>
          <tr>
            <th width="10"></th>
            <th>&nbsp;</th>
            <th>ID</th>
            <th>Name</th>
            <th>Username</th>
            <th>Email</th>
            <th>SKPD</th>
            <th>Role</th>
          </tr>
          {{-- <tr>
            <td></td>
            <td></td>
            <td>
              <input class="search" type="text" placeholder="Cari">
            </td>
            <td>
              <input class="search" type="text" placeholder="Cari">
            </td>
            <td>
              <input class="search" type="text" placeholder="Cari">
            </td>
            <td>
              <input class="search" type="text" placeholder="Cari">
            </td>
            <td>
              <input class="search" type="text" placeholder="Cari">
            </td>
            <td>
              <input class="search" type="text" placeholder="Cari">
            </td>
          </tr> --}}
        </thead>
      </table>
    </div>
  </div>
@endsection
@section('scripts')
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
            data: 'actions',
            name: 'actions'
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
            data: 'skpd.nama',
            name: 'skpd.nama',
          },
          {
            data: 'role',
            name: 'role'
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

      $('.datatable thead').on('input', '.search', function() {
        let strict = $(this).attr('strict') || false
        let value = strict && this.value ? "^" + this.value + "$" : this.value

        let index = $(this).parent().index()
        if (visibleColumnsIndexes !== null) {
          index = visibleColumnsIndexes[index]
        }

        table
          .column(index)
          .search(value, strict)
          .draw()
      });

      table.on('column-visibility.dt', function(e, settings, column, state) {
        visibleColumnsIndexes = []
        table.columns(":visible").every(function(colIdx) {
          visibleColumnsIndexes.push(colIdx);
        });
      });

    });
  </script>
@endsection
