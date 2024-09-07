@extends('layouts.admin', ['title' => 'MenuT Treeview ' . $title])

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tampilan {{ $title }}</h3>
        </div>

        <div class="card-body jstree overflow-auto">
            <ul>
                <li data-jstree='{"opened":true}'>
                    @if ($routePart === 'delapankeldata')
                        8 Kelompok Data
                    @elseif($routePart === 'rpjmd')
                        RPJMD
                    @elseif ($routePart === 'indikator')
                        Indikator
                    @elseif ($routePart === 'bps')
                        BPS
                    @endif
                    @foreach ($categories as $category)
                        @include('admin.treeview.partials.menu', ['category' => $category])
                </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar {{ $title }}</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                {{ $dataTable->table(['class' => 'table-bordered table-striped table-hover datatable datatable-MenuTreeview table table-sm']) }}
            </div>
        </div>
    </div>

    @include('admin.treeview.partials.modal-create')
    @include('admin.treeview.partials.modal-edit')
@endsection
@section('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'text/javascript']) }}
    <script>
        $(function() {
            $.fn.dataTable.ext.buttons.create = {
                text: '<i class="fa-solid fa-plus"></i> Create',
                attr: {
                    "data-toggle": "modal",
                    "data-target": "#modal-create",
                },
                action: function(e) {
                    e.preventDefault();
                },
            };

            $.fn.dataTable.ext.buttons.bulkDelete = {
                text: "Delete selected",
                url: "{{ route('admin.treeview.' . $routePart . '.massDestroy') }}",
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
                    }).then(function(result) {
                        if (result.isConfirmed) {
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
                                success: function(data) {
                                    toastr.success(data.message, "Success");

                                    dt.ajax.reload();
                                },
                            });
                        }
                    });
                },
            };

            $('a[data-toggle="tab"]').on("shown.bs.tab click", function(e) {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            });

            const table = LaravelDataTables["dataTable-MenuTreeView"];

            $("#form-create").on("submit", function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr("action"),
                    headers: {
                        "x-csrf-token": _token,
                    },
                    method: "POST",
                    data: $(this).serializeArray(),
                    success: function(data) {
                        $("#modal-create").modal("hide");

                        toastr.success(data.message, "Success");

                        table.ajax.reload();
                    },
                    beforeSend: function() {
                        $("#form-create fieldset").attr("disabled", "disabled");
                    },
                    complete: function() {
                        $("#form-create fieldset").removeAttr("disabled");
                    },
                });
            });

            table.on("click", ".btn-edit", function(e) {
                e.preventDefault();

                const data = table.row($(this).closest("tr")).data();

                $("#form-edit select[name=parent_id]")
                    .val(data.parent_id)
                    .trigger("change");
                $("#form-edit input[name=nama_menu]").val(data.nama_menu);
                $("#form-edit").attr("action", $(this).attr("href"));

                $("#modal-edit").modal("show");
            });

            $("#form-edit").on("submit", function(e) {
                e.preventDefault();

                const url = $(this).attr("action");

                $.ajax({
                    url: url,
                    headers: {
                        "x-csrf-token": _token,
                    },
                    method: "PUT",
                    data: $(this).serializeArray(),
                    success: function(data) {
                        $("#modal-edit").modal("hide");

                        toastr.success(data.message, "Success");

                        table.ajax.reload();
                    },
                    beforeSend: function() {
                        $("#form-edit fieldset").attr("disabled", "disabled");
                    },
                    complete: function() {
                        $("#form-edit fieldset").removeAttr("disabled");
                    },
                });
            });

            table.on("click", ".btn-delete", function(e) {
                e.preventDefault();

                const url = $(this).attr("href");

                Swal.fire({
                    title: "Apakah anda yakin?",
                    text: 'Anda tidak akan dapat mengembalikan ini!',
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Ya, hapus!",
                    cancelButtonText: "Batal",
                }).then(function(result) {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            headers: {
                                "x-csrf-token": _token,
                            },
                            method: "POST",
                            data: {
                                _method: "DELETE",
                            },
                            success: function(data) {
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
