@extends('layouts.admin', ['title' => 'SKPD List'])

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">SKPD List</h3>
        </div>
        <div class="card-body">
            {{ $dataTable->table(['class' => 'table-bordered table-striped table-hover ajaxTable datatable datatable-skpd table table-sm']) }}
        </div>
    </div>

    @include('admin.skpd.partials.modal-create')
    @include('admin.skpd.partials.modal-edit')
@endsection

@section('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'text/javascript']) }}
    <script>
        $(function() {
            $.fn.dataTable.ext.buttons.create = {
                text: "<i class='fa-solid fa-plus'></i> Create",
                action: function(e, dt, node, config) {
                    $("#modal-create").modal("show");
                },
            };

            $.fn.dataTable.ext.buttons.bulkDelete = {
                text: "Delete selected",
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
                            $.ajax({
                                headers: {
                                    "x-csrf-token": _token,
                                },
                                method: "POST",
                                url: "{{ route('admin.skpd.massDestroy') }}",
                                data: {
                                    ids: ids,
                                    _method: "DELETE",
                                },
                                success: function(data, textStatus, jqXHR) {
                                    toastr.success(data.message, "Success");

                                    dt.ajax.reload();
                                },
                            });
                        }
                    });
                },
            };

            const table = window.LaravelDataTables["dataTable-skpd"];

            $('a[data-toggle="tab"]').on("shown.bs.tab click", function(e) {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
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
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Delete",
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

            $("#modal-create").on("hidden.bs.modal", function() {
                $(this).find("form").trigger("reset");
            });

            $("#modal-create form").on("submit", function(e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ route('admin.skpd.store') }}",
                    method: "POST",
                    headers: {
                        "x-csrf-token": _token,
                    },
                    data: $(this).serializeArray(),
                    success: function(data) {
                        $("#modal-create").modal("hide");

                        toastr.success(data.message, "Success");

                        table.ajax.reload();
                    },
                    beforeSend: function() {
                        $("#modal-create fieldset").attr("disabled", "disabled");
                    },
                    complete: function() {
                        $("#modal-create fieldset").removeAttr("disabled");
                    },
                });
            });

            table.on("click", ".btn-edit", function() {
                const data = table.row($(this).closest("tr")).data();

                $("#modal-edit form select[name=kategori_skpd_id]").val(
                    data.kategori_skpd_id
                );
                $("#modal-edit form input[name=nama]").val(data.nama);
                $("#modal-edit form input[name=singkatan]").val(data.singkatan);
                $("#modal-edit form").attr("action", $(this).data("url"));

                $("#modal-edit").modal("show");
            });

            $("#modal-edit form").on("submit", function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr("action"),
                    method: "PUT",
                    headers: {
                        "x-csrf-token": _token,
                    },
                    data: $(this).serializeArray(),
                    success: function(data) {
                        $("#modal-edit").modal("hide");

                        toastr.success(data.message, "Success");

                        table.ajax.reload();
                    },
                    beforeSend: function() {
                        $("#modal-edit fieldset").attr("disabled", "disabled");
                    },
                    complete: function() {
                        $("#modal-edit fieldset").removeAttr("disabled");
                    },
                });
            });
        });
    </script>
@endsection
