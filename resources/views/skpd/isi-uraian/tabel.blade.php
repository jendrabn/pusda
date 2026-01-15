<div class="d-flex mb-3">
    <a class="btn btn-success"
       href="{{ route('exports.' . $crudRoutePart, $tabel->id) }}">
        <i class="fas fa-file-export mr-1"></i>
        Excel
    </a>
</div>

<table class="table-bordered table-striped table-hover datatable datatable-isiuraian table">
    <thead>
        <tr>
            <th>&nbsp;</th>
            <th class="text-danger">URAIAN</th>
            <th>SATUAN</th>
            @if (in_array($crudRoutePart, ['delapankeldata', 'rpjmd']))
                <th>KETERSEDIAN DATA</th>
            @endif
            @foreach ($tahuns as $tahun)
                <th>{{ $tahun }}</th>
            @endforeach
            @if (in_array($crudRoutePart, ['delapankeldata', 'rpjmd']))
                <th>SUMBER DATA</th>
            @endif
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($uraians as $index => $uraian)
            <tr>
                <td>
                    @if ($uraian->parent_id === null)
                        {{ $index + 1 }}
                    @endif
                </td>
                <td><span class="text-danger">{{ $uraian->uraian }}</span> </td>
                <td>{{ $uraian->satuan }}</td>
                @if (in_array($crudRoutePart, ['delapankeldata', 'rpjmd']))
                    <td>{{ $uraian->ketersediaan_data }}</td>
                @endif
                @foreach ($tahuns as $tahun)
                    <th>&nbsp;</th>
                @endforeach
                @if (in_array($crudRoutePart, ['delapankeldata', 'rpjmd']))
                    <td>&nbsp;</td>
                @endif
                <td>&nbsp;</td>
            </tr>
            @foreach ($uraian->childs as $child)
                <tr>
                    <td>&nbsp;</td>
                    <td><span class="text-danger d-block"
                              style="text-indent: 1.5rem;">{{ $child->uraian }}</span></td>
                    <td>{{ $child->satuan }}</td>
                    @if (in_array($crudRoutePart, ['delapankeldata', 'rpjmd']))
                        <td>{{ $child->label_ketersediaan_data }}</td>
                    @endif
                    @foreach ($tahuns as $tahun)
                        @if ($crudRoutePart === 'delapankeldata')
                            <td>{{ $child->isi8KelData->where('tahun', $tahun)->first()->isi }}</td>
                        @elseif ($crudRoutePart === 'rpjmd')
                            <td>{{ $child->isiRpjmd->where('tahun', $tahun)->first()->isi }}</td>
                        @elseif ($crudRoutePart === 'bps')
                            <td>{{ $child->isiBps->where('tahun', $tahun)->first()->isi }}</td>
                        @elseif ($crudRoutePart === 'indikator')
                            <td>{{ $child->isiIndikator->where('tahun', $tahun)->first()->isi }}</td>
                        @endif
                    @endforeach
                    @if (in_array($crudRoutePart, ['delapankeldata', 'rpjmd']))
                        <td>
                            <select class="form-control sumber-data select2"
                                    data-url="{{ route('admin_skpd.' . $crudRoutePart . '.update_sumber_data', $child->id) }}"
                                    name="sumber_data">
                                <option disabled
                                        hidden
                                        selected></option>
                                @foreach ($skpds as $id => $nama)
                                    <option {{ $id === $child->skpd_id ? 'selected' : '' }}
                                            value="{{ $id }}">
                                        {{ $nama }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    @endif
                    <td>
                        <div class="action-buttons">
                            <button class="btn btn-sm btn-primary btn-show-chart"
                                    data-url="{{ route('admin_skpd.' . $crudRoutePart . '.chart', $child->id) }}"
                                    title="Grafik"
                                    type="button">
                                <i class="fas fa-chart-bar"></i>
                            </button>

                            <a class="btn btn-sm btn-warning"
                               href="{{ route('admin_skpd.' . $crudRoutePart . '.edit', $child->id) }}"
                               title="Edit">
                                <i class="fas fa-pencil-alt"></i>
                            </a>

                            <form action="{{ route('admin_skpd.' . $crudRoutePart . '.destroy', $child->id) }}"
                                  class="action-form"
                                  method="POST"
                                  onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"
                                        title="Delete"
                                        type="submit">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>

                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
