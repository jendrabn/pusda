@extends('layouts.admin')

@section('content')
    @php
        $level = 1;
    @endphp

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Menu Tree View {{ $title }}</h3>
        </div>
        <div class="card-body jstree overflow-auto">
            <ul>
                <li data-jstree='{"opened":true}'>{{ $title }} {{ isset($skpd) && $skpd ? $skpd->singkatan : '' }}
                    @foreach ($kategoris as $kategori)
                        @include('admin.isiUraian.partials.menu', [
                            'child' => $kategori,
                            'level' => $level,
                        ])
                </li>
                @endforeach
            </ul>

        </div>
    </div>

    @if (isset($tabel))
        <div class="card card-outline card-tabs">
            <div class="card-body">
                <ul class="nav nav-tabs mb-3"
                    id="tab">
                    <li class="nav-item">
                        <a aria-controls="tabel"
                           aria-selected="true"
                           class="nav-link {{ request()->get('tab') === 'tabel' || !request()->get('tab') ? 'active' : '' }}"
                           data-toggle="pill"
                           href="#tabel"
                           id="tabel-tab"
                           role="tab">Tabel {{ $title }}</a>
                    </li>
                    <li class="nav-item">
                        <a aria-controls="fitur"
                           aria-selected="false"
                           class="nav-link {{ request()->get('tab') === 'fitur' ? 'active' : '' }}"
                           data-toggle="pill"
                           href="#fitur"
                           id="fitur-tab"
                           role="tab">Fitur {{ $title }}</a>
                    </li>
                    <li class="nav-item">
                        <a aria-controls="file"
                           aria-selected="false"
                           class="nav-link {{ request()->get('tab') === 'file-pendukung' ? 'active' : '' }}"
                           data-toggle="pill"
                           href="#file-pendukung"
                           id="file-tab"
                           role="tab">File Pendukung {{ $title }}</a>
                    </li>
                </ul>

                <div class="tab-content"
                     id="tabContent">
                    <div class="tab-pane fade {{ request()->get('tab') === 'tabel' || !request()->get('tab') ? 'active show' : '' }}"
                         id="tabel">
                        @include('admin.isiUraian.partials.tab-tabel')
                    </div>
                    <div class="tab-pane fade {{ request()->get('tab') === 'fitur' ? 'active show' : '' }}"
                         id="fitur">
                        @include('admin.isiUraian.partials.tab-fitur')
                    </div>
                    <div class="tab-pane fade {{ request()->get('tab') === 'file-pendukung' ? 'active show' : '' }}"
                         id="file-pendukung">
                        @include('admin.isiUraian.partials.tab-file-pendukung')
                    </div>
                </div>
            </div>
        </div>

        <form hidden
              id="form-sumber-data"
              method="POST">
            @csrf
            @method('PUT')
            <input name="skpd_id"
                   type="text" />
        </form>

        <form hidden
              id="form-delete"
              method="POST">
            @csrf
            @method('DELETE')
        </form>

        @include('admin.isiUraian.partials.modal-tahun')
        @include('admin.isiUraian.partials.modal-grafik')
    @endif
@endsection

@section('scripts')
    @if (isset($tabel))
        <script>
            $(function() {
                $('.nav-link[data-toggle="pill"]').on("shown.bs.tab", function(e) {
                    const target = $(e.target).attr("href");
                    const url = new URL(window.location);
                    url.searchParams.set("tab", target.replace("#", ""));
                    window.history.pushState({}, "", url);
                });

                $("table.table-tahun").on("click", ".btn-delete", function(e) {
                    const url = $(this).data("url");

                    Swal.fire({
                        title: "Apakah anda yakin?",
                        text: "Anda tidak akan dapat mengembalikan ini!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Ya, hapus!",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $("#form-delete").attr("action", url);
                            $("#form-delete").submit();
                        }
                    });
                });

                const tableIsiUraian = new DataTable(".dataTable-IsiUraian", {
                    language: {
                        url: "https://cdn.datatables.net/plug-ins/2.1.3/i18n/en-GB.json",
                    },
                    columnDefs: [{
                        orderable: false,
                        target: "_all",
                    }, ],
                    order: [],
                    scrollX: true,
                    pageLength: 50,
                    dom: 'lBfrtip<"actions">',
                    lengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "All"],
                    ],
                    initComplete: function() {
                        this.api().columns.adjust().draw();
                    },
                    buttons: [{
                            extend: "excel",
                            text: '<i class="fa-solid fa-file-excel"></i> Excel',
                            action: function(e, dt, node, config) {
                                window.location.href =
                                    "{{ route('admin.exports.' . $routePart, $tabel->id) }}";
                            },
                        },
                        {
                            text: '<i class="fa-solid fa-calendar-alt"></i> Pengaturan Tahun',
                            attr: {
                                "data-target": "#modal-tahun",
                                "data-toggle": "modal",
                            },
                        },
                        "colvis",
                    ],
                });

                $(".edit-sumber-data").select2();

                tableIsiUraian.on("change", ".edit-sumber-data", function(e) {
                    const url = $(this).data("url");

                    $("#form-sumber-data").attr("action", url);
                    $('#form-sumber-data input[name="skpd_id"]').val($(this).val());
                    $("#form-sumber-data").submit();
                });

                let chart = null;
                tableIsiUraian.on("click", "tbody .btn-grafik", function(e) {
                    $.ajax({
                        method: "GET",
                        url: $(this).data("url"),
                        beforeSend: function() {
                            $("#modal-grafik").modal("show");
                            $("#modal-grafik .modal-body").html("<p>Loading...</p>");
                        },
                        success: function(data) {
                            $("#modal-grafik .modal-body").html("");
                            $("#modal-grafik .modal-body").html(
                                '<canvas width="100%" height="100%"></canvas>'
                            );
                            $("#btn-download-grafik").attr("data-filename", data.uraian);

                            const plugin = {
                                id: "customCanvasBackgroundColor",
                                beforeDraw: (chart, args, options) => {
                                    const {
                                        ctx
                                    } = chart;
                                    ctx.save();
                                    ctx.globalCompositeOperation = "destination-over";
                                    ctx.fillStyle = options.color || "#ffffff";
                                    ctx.fillRect(0, 0, chart.width, chart.height);
                                    ctx.restore();
                                },
                            };

                            const ctx = $("#modal-grafik .modal-body canvas")[0].getContext(
                                "2d"
                            );

                            chart = new Chart(ctx, {
                                type: "line",
                                data: {
                                    labels: data.isi.map((val) => val.tahun),
                                    datasets: [{
                                        label: data.uraian,
                                        data: data.isi.map((val) => val.isi),
                                        borderWidth: 2,
                                        borderColor: "rgba(54, 162, 235, 1)",
                                        backgroundColor: "rgba(54, 162, 235, 0.2)",
                                        pointBackgroundColor: "rgba(255, 99, 132, 1)",
                                        pointBorderColor: "rgba(255, 99, 132, 1)",
                                        pointHoverBackgroundColor: "rgba(255, 206, 86, 1)",
                                        pointHoverBorderColor: "rgba(255, 206, 86, 1)",
                                        fill: true,
                                    }, ],
                                },
                                options: {
                                    responsive: true,
                                    scales: {
                                        x: {
                                            title: {
                                                display: true,
                                                text: "Tahun",
                                            },
                                        },
                                        y: {
                                            title: {
                                                display: true,
                                                text: "Isi",
                                            },
                                            beginAtZero: true,
                                        },
                                    },
                                    plugins: {
                                        legend: {
                                            display: true,
                                            position: "top",
                                        },
                                        tooltip: {
                                            enabled: true,
                                            mode: "index",
                                            intersect: false,
                                        },
                                        customCanvasBackgroundColor: {
                                            color: "white",
                                        },
                                    },
                                },
                                plugins: [plugin],
                            });
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            $("#modal-grafik").modal("hide");
                            toastr.error(
                                jqXHR.responseJSON.message || errorThrown,
                                "Error"
                            );
                        },
                    });
                });

                $("#btn-download-grafik").on("click", function() {
                    const link = document.createElement("a");
                    link.href = chart.toBase64Image("image/jpeg", 1.0);
                    link.download = `Grafik_${$(this).data("filename")}.jpeg`;
                    link.click();
                });

                const tableFilePendukung = $(".dataTable-FilePendukung").DataTable({
                    language: {
                        url: "https://cdn.datatables.net/plug-ins/2.1.3/i18n/en-GB.json",
                    },
                    columnDefs: [{
                            orderable: false,
                            className: "select-checkbox",
                            target: 0,
                            width: 35,
                        },
                        {
                            orderable: false,
                            searchable: false,
                            target: -1,
                        },
                        {
                            visible: false,
                            target: [4, 5],
                        },
                    ],
                    select: {
                        style: "multi+shift",
                        selector: "td:first-child",
                    },
                    order: [
                        [1, "desc"]
                    ],
                    scrollX: true,
                    pageLength: 50,
                    dom: 'lBfrtip<"actions">',
                    lengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "All"],
                    ],
                    initComplete: function() {
                        this.api().columns.adjust().draw();
                    },
                    buttons: [
                        "selectAll",
                        "selectNone",
                        "excel",
                        "colvis",
                        {
                            text: "Delete selected",
                            url: "{{ route('admin.' . $routePart . '.files.massDestroyFile') }}",
                            action: function(e, dt, node, config) {
                                let ids = dt
                                    .rows({
                                        selected: true,
                                    })
                                    .data()
                                    .map(function(row) {
                                        return row[1];
                                    })
                                    .toArray();

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
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $("#form-delete").attr("action", config.url);
                                        $('#form-delete input[name="ids[]"]').remove();
                                        $("#form-delete").append(
                                            ids.map(
                                                (id) =>
                                                `<input type="hidden" name="ids[]" value="${id}" />`
                                            )
                                        );
                                        $("#form-delete").submit();
                                    }
                                });
                            },
                        },
                    ],
                });

                tableFilePendukung.on("click", ".btn-delete", function(e) {
                    const url = $(this).data("url");

                    Swal.fire({
                        title: "Apakah anda yakin?",
                        text: "Anda tidak akan dapat mengembalikan ini!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Ya, hapus!",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $("#form-delete").attr("action", url);
                            $("#form-delete").submit();
                        }
                    });
                });

                $('a[data-toggle="tab"], .nav-link[data-toggle="pill"]').on(
                    "shown.bs.tab click",
                    function(e) {
                        tableIsiUraian.columns.adjust();
                        tableFilePendukung.columns.adjust();
                    });
            });
        </script>
    @endif
@endsection
