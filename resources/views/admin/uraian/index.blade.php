@extends('layouts.admin', ['title' => $title])

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Pilih Menu Treeview {{ $title }}</h3>
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
                        @include('admin.uraian.partials.menu', ['child' => $category, 'level' => 1])
                </li>
                @endforeach
            </ul>
        </div>
    </div>

    @if ($tabel)
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Uraian Form {{ $tabel->nama_menu }}</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    {{ $dataTable->table(['class' => 'table-bordered table-striped table-hover ajaxTable datatable datatable-Uraian table table-sm']) }}
                </div>
            </div>
        </div>

        @include('admin.uraian.partials.modal-create')
        @include('admin.uraian.partials.modal-edit')
    @endif
@endsection

@section('scripts')
    @if ($tabel)
        {{ $dataTable->scripts(attributes: ['type' => 'text/javascript']) }}

        <script>
            $(function() {
                async function fetchKategoriOptions(selectedId = null) {
                    await $.ajax({
                        url: "{{ route('admin.uraian.' . $routePart . '.uraians', $tabel->id) }}",
                        type: "GET",
                        beforeSend: function() {
                            $("form select[name=parent_id]").attr(
                                "disabled",
                                "disabled"
                            );

                            $("form select[name=parent_id]").html(
                                "<option>Loading...</option>"
                            );
                        },
                        success: function(data) {
                            let options = `<option value="" ${
						!selectedId ? "selected" : ""
					}>Parent</option>`;

                            data.forEach((item) => {
                                options += `<option value="${item.id}" ${
							selectedId === item.id ? "selected" : ""
						}>${item.uraian}</option>`;
                            });

                            $("form select[name=parent_id]").html(options);
                        },
                        complete: function() {
                            $("form select[name=parent_id]").removeAttr("disabled");
                        },
                    });
                }

                $.fn.dataTable.ext.buttons.create = {
                    text: '<i class="fa-solid fa-plus"></i> Create',
                    attr: {
                        "data-toggle": "modal",
                        "data-target": "#modal-create",
                    },
                    action: function(e) {
                        e.preventDefault();

                        fetchKategoriOptions();
                    },
                };

                $.fn.dataTable.ext.buttons.bulkDelete = {
                    text: "Delete selected",
                    url: "{{ route('admin.uraian.' . $routePart . '.massDestroy') }}",
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
                            text: "Anda tidak akan dapat mengembalikan ini!",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonText: "Ya, hapus!",
                            cancelButtonText: "Batal",
                        }).then(function(result) {
                            if (result.value) {
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

                const table = LaravelDataTables["dataTable-Uraian"];

                table.on("click", ".btn-delete", function(e) {
                    const url = $(this).data("url");

                    Swal.fire({
                        title: "Apakah anda yakin?",
                        text: "Anda tidak akan dapat mengembalikan ini!",
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

                $("#modal-create form").on("submit", function(e) {
                    e.preventDefault();

                    $.ajax({
                        url: "{{ route('admin.uraian.' . $routePart . '.store', $tabel->id) }}",
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
                            $("#modal-create form fieldset").attr(
                                "disabled",
                                "disabled"
                            );
                        },
                        complete: function() {
                            $("#modal-create form fieldset").removeAttr("disabled");
                        },
                    });
                });

                table.on("click", ".btn-edit", function(e) {
                    e.preventDefault();

                    const data = table.row($(this).closest("tr")).data();

                    $("#modal-edit form").attr("action", $(this).data("url"));
                    $("#modal-edit form input[name=uraian]").val(data.uraian);
                    $("#modal-edit").modal("show");

                    fetchKategoriOptions(data.parent_id);
                });

                $("#modal-edit form").on("submit", function(e) {
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
                            $("#modal-edit form fieldset").attr("disabled", "disabled");
                        },
                        complete: function() {
                            $("#modal-edit form fieldset").removeAttr("disabled");
                        },
                    });
                });

                $("#modal-create").on("hidden.bs.modal", function(e) {
                    $(this).find("form").trigger("reset");
                });

                $('a[data-toggle="tab"]').on("shown.bs.tab click", function(e) {
                    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
                });
            });
        </script>
    @endif
@endsection
