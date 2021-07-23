@extends('guest.layouts.app')

@section('title')
  Tabel Uraian BPS
@endsection

@section('content')
  <div class="container">
    <div class="card">
      <div class="card-header bg-white card-header__lg">
        <h4 class="card-header__title">Tabel Uraian "{{ $tabelBps->menu_name }}" BPS</h4>
      </div>
      <div class="card-body">
        <div class="action">
          @include('guest.partials.button-export', ['id' => $tabelBps->id, 'resourceName' => 'bps'])
        </div>
        <div class="table-responsive">
          <table class="table table-bordered table-hover">
            <thead>
              <tr class="table-secondary">
                <th>No</th>
                <th class="text-danger">Uraian</th>
                <th>Satuan</th>
                @foreach ($years as $year)
                  <th>{{ $year }}</th>
                @endforeach
                <th>Grafik</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($uraianBps as $i => $uraian)
                <tr>
                  <td>{{ ++$i }}</td>
                  <td class="text-danger font-weight-bolder">{{ $uraian->uraian }}</td>
                  <td>{{ $uraian->satuan }}</td>
                  @foreach ($years as $year)
                    <th></th>
                  @endforeach
                  <th></th>
                </tr>

                @foreach ($uraian->childs as $child)
                  <tr>
                    <td></td>
                    <td class="text-danger" style="text-indent: 1rem;">{{ $child->uraian }}</td>
                    <td>{{ $child->satuan }}</td>
                    @foreach ($years as $year)
                      <td> {{ $child->isiBps->where('tahun', $year)->first()->isi }}</td>
                    @endforeach
                    <td class="text-center">
                      <button type="button" class="btn btn-primary btn-sm btn-chart"
                        data-id="{{ $child->id }}">Grafik</button>
                    </td>
                  </tr>
                @endforeach
              @endforeach
              @include('guest.partials.fitur', ['fitur' => $fiturBps, 'colspan' => 6 + count($years)])
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  @include('guest.partials.modal-graphic')
@endsection

@push('scripts')
  <script>
    initHandleShowChartModal('bps')
  </script>
@endpush
