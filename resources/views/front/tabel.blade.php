@extends('layouts.front', ['title' => $title])

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header card-header__lg bg-white">
                <h4 class="card-header__title">Tabel Uraian "{{ $tabel->nama_menu }}" {{ $title }}</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table-bordered table-hover table"
                           id="table-isiUraian">
                        <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th class="text-danger">Uraian</th>
                                <th>Satuan</th>
                                @if (in_array($routePart, ['delapankeldata', 'rpjmd']))
                                    <th>Ketersedian Data</th>
                                @endif
                                @foreach ($tahuns as $tahun)
                                    <th>{{ $tahun }}</th>
                                @endforeach
                                <th>Grafik</th>
                                @if (in_array($routePart, ['delapankeldata', 'rpjmd']))
                                    <th>Sumber Data</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($uraians as $index => $uraian)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="text-danger font-weight-bolder">{{ $uraian->uraian }}</td>
                                    <td>{{ $uraian->satuan }}</td>
                                    @if (in_array($routePart, ['delapankeldata', 'rpjmd']))
                                        <td>{{ $uraian->ketersediaan_data_text }}</td>
                                    @endif
                                    @foreach ($tahuns as $tahun)
                                        <th>&nbsp;</th>
                                    @endforeach
                                    <td>&nbsp;</td>
                                    @if (in_array($routePart, ['delapankeldata', 'rpjmd']))
                                        <td>{{ $uraian->skpd?->nama }}</td>
                                    @endif
                                </tr>

                                @foreach ($uraian->childs as $child)
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td class="text-danger"
                                            style="text-indent: 1rem;">{{ $child->uraian }}</td>
                                        <td>{{ $child->satuan }}</td>
                                        @if (in_array($routePart, ['delapankeldata', 'rpjmd']))
                                            <td>{{ $child->ketersediaan_data_text }}</td>
                                        @endif
                                        @foreach ($tahuns as $tahun)
                                            @if ($routePart === 'delapankeldata')
                                                <td>{{ $child->isi8KelData->where('tahun', $tahun)->first()->isi }}</td>
                                            @elseif ($routePart === 'rpjmd')
                                                <td>{{ $child->isiRpjmd->where('tahun', $tahun)->first()->isi }}</td>
                                            @elseif ($routePart === 'bps')
                                                <td>{{ $child->isiBps->where('tahun', $tahun)->first()->isi }}</td>
                                            @elseif ($routePart === 'indikator')
                                                <td>{{ $child->isiIndikator->where('tahun', $tahun)->first()->isi }}</td>
                                            @endif
                                        @endforeach
                                        <td class="text-center">
                                            <button class="btn btn-primary btn-sm btn-grafik"
                                                    data-url="{{ route($routePart . '.chart', $child->id) }}"
                                                    type="button">Grafik</button>
                                        </td>
                                        @if (in_array($routePart, ['delapankeldata', 'rpjmd']))
                                            <td>{{ $child->skpd?->nama }}</td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endforeach

                            @include('front.partials.fitur', ['colspan' => 6 + count($tahuns)])
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('front.partials.modal-grafik')
@endsection

@section('scripts')
    <script>
        $(function() {
            let chart = null;
            $('#table-isiUraian').on("click", "tbody .btn-grafik", function(e) {
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
        })
    </script>
@endsection
