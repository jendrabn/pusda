@extends('layouts.admin', ['title' => 'Audit Logs'])

@section('content')
  <div class="card">
    <div class="card-header ">
      Audit Log List
    </div>

    <div class="card-body">
      <table class="table table-bordered table-striped table-hover ajaxTable datatable datatable-AuditLog">
        <thead>
          <tr>
            <th width="10"></th>
            <th>ID</th>
            <th>Description</th>
            <th>Subject ID</th>
            <th>Subject Type</th>
            <th>User ID</th>
            <th>Host</th>
            <th>Created at</th>
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

      let dtOverrideGlobals = {
        buttons: dtButtons,
        processing: true,
        serverSide: true,
        retrieve: true,
        aaSorting: [],
        ajax: "{{ route('admin.audit-logs.index') }}",
        columns: [{
            data: 'placeholder',
            name: 'placeholder'
          },
          {
            data: 'id',
            name: 'id'
          },
          {
            data: 'description',
            name: 'description'
          },
          {
            data: 'subject_id',
            name: 'subject_id'
          },
          {
            data: 'subject_type',
            name: 'subject_type'
          },
          {
            data: 'user_id',
            name: 'user_id'
          },
          {
            data: 'host',
            name: 'host'
          },
          {
            data: 'created_at',
            name: 'created_at'
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
        pageLength: 50,
      };
      let table = $('.datatable-AuditLog').DataTable(dtOverrideGlobals);
      $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
        $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
      });

    });
  </script>
@endsection
