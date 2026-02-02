@extends('layouts.front', ['title' => $title])

@section('content')
    <div class="container">
        <div class="surface">
            <div class="surface-head">
                <span class="section-eyebrow">Data</span>
                <h2>Tabel Uraian "{{ $tabel->nama_menu }}" {{ $title }}</h2>
            </div>
            <div class="surface-body">
                <div class="action">

                    <a class="btn btn-success text-white"
                       href="{{ route('exports.' . $routePart, $tabel->id) }}">
					   Download Data
                       <i class="fa-solid fa-download ms-1"></i>
                    </a>

                </div>
                <div class="table-responsive">
                    <table class="table-bordered table-hover table-isiuraian table">
                        <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th class="text-danger">URAIAN</th>
                                <th>SATUAN</th>
                                @if (in_array($routePart, ['delapankeldata', 'rpjmd']))
                                    <th>KETERSEDIAN DATA</th>
                                @endif
                                @foreach ($tahuns as $tahun)
                                    <th>{{ $tahun }}</th>
                                @endforeach
                                <th>GRAFIK</th>
                                @if (in_array($routePart, ['delapankeldata', 'rpjmd']))
                                    <th>SUMBER DATA</th>
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
                                            <button class="btn btn-primary btn-show-chart"
                                                    data-url="{{ route($routePart . '.chart', $child->id) }}"
                                                    type="button">
                                              <i class="fa-solid fa-chart-column"></i>
                                        </td>
                                        @if (in_array($routePart, ['delapankeldata', 'rpjmd']))
                                            <td>{{ $child->skpd?->nama }}</td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endforeach

                            @include('front.fitur', ['colspan' => 6 + count($tahuns)])
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('front.chart-modal')
@endsection

@section('scripts')
    <script>
        (() => {
            class FrontChartViewer {
                constructor() {
                    this.table = document.querySelector('.table-isiuraian');
                    this.modalEl = document.getElementById('modal-chart');
                    this.canvas = document.getElementById('chart-isi-uraian');
                    this.loadingEl = document.getElementById('chart-loading');
                    this.errorEl = document.getElementById('chart-error');
                    this.modalTitle = document.getElementById('chart-modal-title');
                    this.modal = this.modalEl ? new bootstrap.Modal(this.modalEl) : null;
                    this.chart = null;
                    this.abortController = null;
                    this.numberFormatter = new Intl.NumberFormat('id-ID');
                }

                init() {
                    if (!this.table || !this.modal || typeof Chart === 'undefined') {
                        return;
                    }

                    this.table.addEventListener('click', (event) => this.handleChartClick(event));
                    this.modalEl.addEventListener('hidden.bs.modal', () => this.handleModalHidden());
                }

                async handleChartClick(event) {
                    const button = event.target.closest('.btn-show-chart');
                    if (!button) {
                        return;
                    }

                    event.preventDefault();

                    const chartUrl = button.dataset.url;
                    if (!chartUrl) {
                        return;
                    }

                    this.modal.show();
                    this.showLoading();

                    try {
                        const data = await this.fetchChartData(chartUrl);
                        const normalized = this.normalizeChartData(data);

                        if (!normalized.values.some((val) => val !== null)) {
                            throw new Error('Data grafik belum tersedia atau bukan numerik.');
                        }

                        this.modalTitle.textContent = `Grafik Data: ${normalized.title}`;
                        this.renderChart(normalized);
                        this.showChart();
                    } catch (error) {
                        if (error.name === 'AbortError') {
                            return;
                        }

                        this.showError(error.message || 'Terjadi kesalahan saat memuat grafik.');
                    }
                }

                async fetchChartData(url) {
                    if (this.abortController) {
                        this.abortController.abort();
                    }

                    this.abortController = new AbortController();
                    const response = await fetch(url, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            Accept: 'application/json'
                        },
                        signal: this.abortController.signal
                    });

                    if (!response.ok) {
                        throw new Error('Gagal mengambil data grafik.');
                    }

                    return response.json();
                }

                normalizeChartData(payload) {
                    const title = payload?.uraian || 'Grafik';
                    const items = Array.isArray(payload?.isi) ? payload.isi : [];
                    const labels = items.map((item) => item?.tahun ?? '-');
                    const values = items.map((item) => this.toNumber(item?.isi));

                    return {
                        title,
                        labels,
                        values
                    };
                }

                toNumber(value) {
                    if (typeof value === 'number' && Number.isFinite(value)) {
                        return value;
                    }

                    if (typeof value !== 'string') {
                        return null;
                    }

                    let sanitized = value.trim().replace(/\s+/g, '').replace(/[^0-9,.-]/g, '');
                    if (!sanitized) {
                        return null;
                    }

                    if (sanitized.includes(',') && sanitized.includes('.')) {
                        sanitized = sanitized.lastIndexOf(',') > sanitized.lastIndexOf('.') ?
                            sanitized.replace(/\./g, '').replace(',', '.') :
                            sanitized.replace(/,/g, '');
                    } else if (sanitized.includes(',')) {
                        const commas = (sanitized.match(/,/g) || []).length;
                        sanitized = commas > 1 ? sanitized.replace(/,/g, '') : sanitized.replace(',', '.');
                    }

                    const parsed = Number.parseFloat(sanitized);
                    return Number.isFinite(parsed) ? parsed : null;
                }

                renderChart({
                    title,
                    labels,
                    values
                }) {
                    if (this.chart) {
                        this.chart.destroy();
                    }

                    const context = this.canvas.getContext('2d');
                    const gradient = context.createLinearGradient(0, 0, 0, 340);
                    gradient.addColorStop(0, 'rgba(31, 111, 139, 0.9)');
                    gradient.addColorStop(1, 'rgba(31, 111, 139, 0.3)');

                    this.chart = new Chart(context, {
                        type: 'bar',
                        data: {
                            labels,
                            datasets: [{
                                label: title,
                                data: values,
                                backgroundColor: gradient,
                                borderColor: '#1f6f8b',
                                borderWidth: 1.2,
                                borderRadius: 10,
                                maxBarThickness: 48,
                                hoverBackgroundColor: '#2e88ad'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            animation: {
                                duration: 550,
                                easing: 'easeOutQuart'
                            },
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    backgroundColor: '#0f172a',
                                    titleFont: {
                                        weight: '700'
                                    },
                                    callbacks: {
                                        label: (context) =>
                                            `${context.dataset.label}: ${this.numberFormatter.format(context.raw)}`
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    grid: {
                                        display: false
                                    },
                                    ticks: {
                                        color: '#4f5d75'
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(15, 23, 42, 0.08)'
                                    },
                                    ticks: {
                                        color: '#4f5d75',
                                        callback: (value) => this.numberFormatter.format(value)
                                    }
                                }
                            }
                        }
                    });
                }

                showLoading() {
                    this.loadingEl.classList.remove('d-none');
                    this.errorEl.classList.add('d-none');
                    this.canvas.classList.add('d-none');
                }

                showError(message) {
                    this.loadingEl.classList.add('d-none');
                    this.canvas.classList.add('d-none');
                    this.errorEl.textContent = message;
                    this.errorEl.classList.remove('d-none');
                }

                showChart() {
                    this.loadingEl.classList.add('d-none');
                    this.errorEl.classList.add('d-none');
                    this.canvas.classList.remove('d-none');
                }

                handleModalHidden() {
                    if (this.abortController) {
                        this.abortController.abort();
                    }

                    if (this.chart) {
                        this.chart.destroy();
                        this.chart = null;
                    }
                }
            }

            document.addEventListener('DOMContentLoaded', () => {
                const chartViewer = new FrontChartViewer();
                chartViewer.init();
            });
        })();
    </script>
@endsection
