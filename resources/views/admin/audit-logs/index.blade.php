@extends('layouts.admin', ['title' => 'Audit Logs'])

@section('content')
    <div class="card">
        <div class="card-header">
            Audit Log List
        </div>

        <div class="card-body">
            <table class="table-bordered table-striped table-hover ajaxTable datatable datatable-AuditLog table ">
                <thead>
                    <tr>
                        <th width="10">&nbsp;</th>
                        <th>ID</th>
                        <th>DESCRIPTION</th>
                        <th>SUBJECT ID</th>
                        <th>SUBJECT TYPE</th>
                        <th>USER ID</th>
                        <th>HOST</th>
                        <th>CREATED AT</th>
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
            let _token = $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').val();

            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);

            let deleteButtonText = "Delete selected";
            let deleteButton = {
                text: deleteButtonText,
                url: "{{ route('admin.audit-logs.massDestroy') }}",
                className: "btn-danger",
                action: function (e, dt, node, config) {
                    var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
                        return entry.id
                    });

                    if (ids.length === 0) {
                        alert('No rows selected');
                        return;
                    }

                    if (confirm('Are You Sure?')) {
                        $.ajax({
                            headers: {'x-csrf-token': _token},
                            method: 'POST',
                            url: config.url,
                            data: { ids: ids, _method: 'DELETE' }
                        })
                            .done(function () { location.reload() });
                    }
                }
            };
            dtButtons.push(deleteButton);

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
                        name: 'actions',
                        searchable: false,
                        orderable: false
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
