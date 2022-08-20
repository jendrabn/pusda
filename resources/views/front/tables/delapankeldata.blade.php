@extends('layouts.appFront')
@section('title', 'Tabel Uraian 8 Kelompok Data')
@section('content')
  <div class="container">
    <div class="card">
      <div class="card-header bg-white card-header__lg">
        <h4 class="card-header__title">Tabel Uraian "{{ $tabel8KelData->nama_menu }}" 8 Kelompok Data</h4>
      </div>
      <div class="card-body">
        <div class="action">
          @include('front.partials.buttonExport', [
              'id' => $tabel8KelData->id,
              'routePart' => 'delapankeldata',
          ])
        </div>
        <div class="table-responsive">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>No</th>
                <th class="text-danger">Uraian</th>
                <th>Satuan</th>
                <th>Ketersedian Data</th>
                @foreach ($years as $year)
                  <th>{{ $year }}</th>
                @endforeach
                <th>Grafik</th>
                <th>Sumber Data</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($uraian8KelData as $i => $uraian)
                <tr>
                  <td>{{ ++$i }}</td>
                  <td class="text-danger font-weight-bolder">{{ $uraian->uraian }}</td>
                  <td>{{ $uraian->satuan }}</td>
                  <td>{{ $uraian->ketersediaan_data_text }}</td>
                  @foreach ($years as $year)
                    <th></th>
                  @endforeach
                  <td></td>
                  <td>{{ $uraian->skpd->singkatan ?? '-' }}</td>
                </tr>

                @foreach ($uraian->childs as $child)
                  <tr>
                    <td></td>
                    <td class="text-danger" style="text-indent: 1rem;">{{ $child->uraian }}</td>
                    <td>{{ $child->satuan }}</td>
                    <td>{{ $child->ketersediaan_data_text }}</td>
                    @foreach ($years as $year)
                      <td> {{ $child->isi8KelData->where('tahun', $year)->first()->isi }}</td>
                    @endforeach
                    <td class="text-center">
                      <button type="button" class="btn btn-primary btn-sm btn-chart"
                        data-id="{{ $child->id }}">Grafik</button>
                    </td>
                    <td>{{ $child->skpd->singkatan ?? '-' }}</td>
                  </tr>
                @endforeach
              @endforeach
              @include('front.partials.fitur', ['fitur' => $fitur8KelData, 'colspan' => 6 + count($years)])
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  @include('front.partials.modalGraphic')
@endsection

@section('scripts')
  @parent
  <script>
    initHandleShowChartModal('delapankeldata')
  </script>
@endsection
