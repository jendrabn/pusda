@php $fullcolspan = 3 + count($tahuns); @endphp

<table>
  <thead>
    <tr>
      <th>No.</th>
      <th>Uraian</th>
      <th>Satuan</th>
      @if (in_array($crudRoutePart, ['delapankeldata', 'rpjmd']))
        <th>Ketersedian Data</th>
        @endif @foreach ($tahuns as $tahun)
          <th>{{ $tahun }}</th>
          @endforeach @if (in_array($crudRoutePart, ['delapankeldata', 'rpjmd']))
            <th>Sumber Data</th>
          @endif
    </tr>
  </thead>
  <tbody>
    @foreach ($uraians as $index => $uraian)
      <tr>
        <th>{{ $index + 1 }}</th>
        <th colspan="{{ count($tahuns) + 1 }}">{{ $uraian->uraian }}</th>
      </tr>
      @foreach ($uraian->childs as $uraian)
        <tr>
          <th>&nbsp;</th>
          <th>{{ $uraian->uraian }}</th>
          <th>{{ $uraian->satuan }}</th>
          @if (in_array($crudRoutePart, ['delapankeldata', 'rpjmd']))
            <th>{{ $uraian->label_ketersediaan_data }}</th>
            @endif @foreach ($tahuns as $tahun)
              @if ($crudRoutePart === 'delapankeldata')
                <th>{{ $uraian->isi8KelData->where('tahun', $tahun)->first()->isi }}</th>
              @elseif ($crudRoutePart === 'rpjmd')
                <th>{{ $uraian->isiRpjmd->where('tahun', $tahun)->first()->isi }}</th>
              @elseif ($crudRoutePart === 'bps')
                <th>{{ $uraian->isiBps->where('tahun', $tahun)->first()->isi }}</th>
              @elseif ($crudRoutePart === 'indikator')
                <th>{{ $uraian->isiIndikator->where('tahun', $tahun)->first()->isi }}</th>
              @endif
              @endforeach @if (in_array($crudRoutePart, ['delapankeldata', 'rpjmd']))
                <th>{{ $uraian->skpd?->nama }}</th>
              @endif
        </tr>
      @endforeach
    @endforeach

    {{-- Border --}}
    <tr>
      <td colspan="{{ $fullcolspan }}"></td>
    </tr>
    <tr>
      <td colspan="{{ $fullcolspan }}">Deskripsi:</td>
    </tr>
    <tr>
      <td colspan="{{ $fullcolspan }}">{{ $fitur?->deskripsi }}</td>
    </tr>
    {{-- Border --}}

    {{-- Border --}}
    <tr>
      <td colspan="{{ $fullcolspan }}"></td>
    </tr>
    <tr>
      <td colspan="{{ $fullcolspan }}">Analisis:</td>
    </tr>
    <tr>
      <td colspan="{{ $fullcolspan }}">{{ $fitur?->analisis }}</td>
    </tr>
    {{-- Border --}}

    {{-- Border --}}
    <tr>
      <td colspan="{{ $fullcolspan }}"></td>
    </tr>
    <tr>
      <td colspan="{{ $fullcolspan }}">Permasalahan:</td>
    </tr>
    <tr>
      <td colspan="{{ $fullcolspan }}">{{ $fitur?->permasalahan }}</td>
    </tr>
    {{-- Border --}}

    {{-- Border --}}
    <tr>
      <td colspan="{{ $fullcolspan }}"></td>
    </tr>
    <tr>
      <td colspan="{{ $fullcolspan }}">
        Solusi atau Langkah-langkah Tindak Lanjut:
      </td>
    </tr>
    <tr>
      <td colspan="{{ $fullcolspan }}">{{ $fitur?->solusi }}</td>
    </tr>
    {{-- Border --}}

    {{-- Border --}}
    <tr>
      <td colspan="{{ $fullcolspan }}"></td>
    </tr>
    <tr>
      <td colspan="{{ $fullcolspan }}">
        Saran / Rekomendasi ke Gubernur atau Pusat:
      </td>
    </tr>
    <tr>
      <td colspan="{{ $fullcolspan }}">{{ $fitur?->saran }}</td>
    </tr>
    {{-- Border --}}
  </tbody>
</table>
