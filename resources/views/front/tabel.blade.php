@extends('layouts.front', ['title' => $title])

@section('content')
  <div class="container">
    <div class="card">
      <div class="card-header card-header__lg bg-white">
        <h4 class="card-header__title">Tabel Uraian "{{ $tabel->nama_menu }}" {{ $title }}</h4>
      </div>
      <div class="card-body">
        <div class="action">
          <div class="btn-group">
            <button class="btn btn-success btn-flat dropdown-toggle" data-bs-toggle="dropdown" type="button"
              aria-expanded="false">
              <i class="fas fa-file-export"></i> Export
            </button>
            <ul class="dropdown-menu">
              <a class="dropdown-item"
                href="{{ route('exports.' . $routePart, [$tabel->id, 'format' => 'csv']) }}">csv</a>
              <a class="dropdown-item"
                href="{{ route('exports.' . $routePart, [$tabel->id, 'format' => 'xls']) }}">xls</a>
              <a class="dropdown-item"
                href="{{ route('exports.' . $routePart, [$tabel->id, 'format' => 'xlsx']) }}">xlsx</a>
            </ul>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table-bordered table-hover table-isiuraian table">
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
                    <td class="text-danger" style="text-indent: 1rem;">{{ $child->uraian }}</td>
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
                      <button class="btn btn-primary btn-sm btn-show-chart"
                        data-url="{{ route($routePart . '.chart', $child->id) }}" type="button">Grafik</button>
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
    $('.table-isiuraian').on('click', 'tbody .btn-show-chart', function(e) {
      const containerElm = $('#chart-container');
      const chartElm = $('#chart-isi-uraian');

      $.ajax({
        method: 'GET',
        url: $(this).data('url'),
        success: function(data) {

          chartElm.remove();
          containerElm.append('<canvas id="chart-isi-uraian" width="100%" height="100%"></canvas>');
          const ctx = $('#chart-isi-uraian');

          const chart = new Chart(ctx, {
            type: 'bar',
            data: {
              labels: data.isi.map(val => val.tahun),
              datasets: [{
                label: data.uraian,
                data: data.isi.map(val => val.isi),
                backgroundColor: "#36a2eb",
                borderWidth: 1
              }]
            },
            options: {
              indexAxis: 'y',
              responsive: true,
            }
          });

          (new bootstrap.Modal('#modal-chart', {
            keyboard: false
          })).show();
        },
        error: function(err) {
          console.log(err);
        }
      });

    });
  </script>
@endsection
