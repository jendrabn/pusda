@extends('layouts.admin', ['title' => 'Users'])

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">User List</h3>
        </div>
        <div class="card-body">
            {{ $dataTable->table(['class' => 'table-bordered table-striped table-hover ajaxTable datatable datatable-User table table-sm']) }}
        </div>
    </div>
    @endsection @section('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'text/javascript']) }}
    <script>
        $(function() {
            $.fn.dataTable.ext.buttons.bulkDelete = {
                text: 'Delete Selected',
                action: function(e, dt, node, config) {
                    let ids = $.map(
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
                        toastr.error("No rows selected", "Error");

                        return;
                    }

                    Swal.fire({
                        title: "Apakah anda yakin?",
                        text: 'Anda tidak akan dapat mengembalikan ini!',
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Ya, hapus!",
                        cancelButtonText: "Batal",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const btn = this;

                            $.ajax({
                                headers: {
                                    "x-csrf-token": _token,
                                },
                                method: "POST",
                                url: "{{ route('admin.users.massDestroy') }}",
                                data: {
                                    ids: ids,
                                    _method: "DELETE",
                                },
                                success: function(data, textStatus, jqXHR) {
                                    toastr.success(data.message, "Success");

                                    dt.ajax.reload();
                                }
                            });
                        }
                    });
                },
            };

            const table = window.LaravelDataTables["dataTable-users"];

            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

            let visibleColumnsIndexes = null;

            $(".datatable thead").on("input", ".search", function() {
                let strict = $(this).attr("strict") || false;
                let value =
                    strict && this.value ? "^" + this.value + "$" : this.value;

                let index = $(this).parent().index();
                if (visibleColumnsIndexes !== null) {
                    index = visibleColumnsIndexes[index];
                }

                table.column(index).search(value, strict).draw();
            });

            table.on("column-visibility.dt", function(e, settings, column, state) {
                visibleColumnsIndexes = [];

                table.columns(":visible").every(function(colIdx) {
                    visibleColumnsIndexes.push(colIdx);
                });
            });

            table.on("click", ".btn-delete", function() {
                const url = $(this).data("url");

                Swal.fire({
                    title: "Apakah anda yakin?",
                    text: 'Anda tidak akan dapat mengembalikan ini!',
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Ya, hapus!",
                    cancelButtonText: "Batal",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: "POST",
                            headers: {
                                "x-csrf-token": _token,
                            },
                            data: {
                                _method: "DELETE",
                            },
                            success: function(data, textStatus, jqXHR) {
                                toastr.success(data.message, "Success");

                                table.ajax.reload();
                            },
                        });
                    }
                });
            });


        });
    </script>
@endsection
