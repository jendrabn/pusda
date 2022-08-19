@extends('layouts.admin')


@section('title', 'SKPD List')

@section('content')
  <div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
      <a class="btn btn-success" href="{{ route('admin.skpd.create') }}">
        Add SKPD
      </a>
    </div>
  </div>
  <div class="card">
    <div class="card-header">
      SKPD List
    </div>

    <div class="card-body">
      <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-skpd">
        <thead>
          <tr>
            <th width="10">

            </th>
            <th>
              ID
            </th>
            <th>
              Nama
            </th>
            <th>
              Singkatan
            </th>
            <th>
              Kategori
            </th>
            <th>
              &nbsp;
            </th>
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
      let deleteButtonTrans = 'Delete selected';
      let deleteButton = {
        text: deleteButtonTrans,
        url: "{{ route('admin.skpd.massDestroy') }}",
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
        ajax: "{{ route('admin.skpd.index') }}",
        columns: [{
            data: 'placeholder',
            name: 'placeholder'
          },
          {
            data: 'id',
            name: 'id'
          },
          {
            data: 'nama',
            name: 'nama'
          },
          {
            data: 'singkatan',
            name: 'singkatan'
          },
          {
            data: 'category',
            name: 'category.name'
          },
          {
            data: 'actions',
            name: 'actions'
          }
        ],
        orderCellsTop: true,
        order: [
          [1, 'desc']
        ],
        pageLength: 25,
      };
      let table = $('.datatable-skpd').DataTable(dtOverrideGlobals);
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
      })
    });
  </script>
@endsection
