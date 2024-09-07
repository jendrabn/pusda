<div class="table-responsive">
    <table class="table-bordered table-striped table-hover datatable dataTable-IsiUraian table table-sm text-center">
        <thead>
            <tr>
                <th>
                    No.
                </th>
                <th class="text-danger">
                    Uraian
                </th>
                <th>
                    Satuan
                </th>
                @if (in_array($routePart, ['delapankeldata', 'rpjmd']))
                    <th>
                        Ketersedian Data
                    </th>
                @endif
                @foreach ($tahuns as $tahun)
                    <th>
                        {{ $tahun }}
                    </th>
                @endforeach
                @if (in_array($routePart, ['delapankeldata', 'rpjmd']))
                    <th>
                        Sumber Data
                    </th>
                @endif
                <th>
                    &nbsp;
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($uraians as $index => $uraian)
                <tr>
                    <td class="text-center"
                        style="width: 35px;">
                        @if (!$uraian->parent_id)
                            {{ $loop->iteration }}
                        @endif
                    </td>
                    <td class="text-danger text-left font-weight-bold">
                        {{ $uraian->uraian }}
                    </td>
                    <td>
                        {{ $uraian->satuan }}
                    </td>
                    @if (in_array($routePart, ['delapankeldata', 'rpjmd']))
                        <td>
                            {{ $uraian->ketersediaan_data }}
                        </td>
                    @endif
                    @foreach ($tahuns as $tahun)
                        <td>
                            &nbsp;
                        </td>
                    @endforeach
                    @if (in_array($routePart, ['delapankeldata', 'rpjmd']))
                        <td>
                        </td>
                    @endif
                    <td>
                    </td>
                </tr>
                @foreach ($uraian->childs as $child)
                    <tr>
                        <td></td>
                        <td class="text-danger text-left"
                            style="text-indent: 1.5rem;">
                            {{ $child->uraian }}
                        </td>
                        <td>{{ $child->satuan }}</td>
                        @if (in_array($routePart, ['delapankeldata', 'rpjmd']))
                            <td>
                                {{ $child->label_ketersediaan_data }}
                            </td>
                        @endif
                        @foreach ($tahuns as $tahun)
                            @if ($routePart === 'delapankeldata')
                                <td>
                                    {{ number_format($child->isi8KelData->where('tahun', $tahun)->first()?->isi, 0, ',', '.') }}
                                </td>
                            @elseif ($routePart === 'rpjmd')
                                <td>
                                    {{ number_format($child->isiRpjmd->where('tahun', $tahun)->first()?->isi, 0, ',', '.') }}
                                </td>
                            @elseif ($routePart === 'bps')
                                <td>
                                    {{ number_format($child->isiBps->where('tahun', $tahun)->first()?->isi, 0, ',', '.') }}
                                </td>
                            @elseif ($routePart === 'indikator')
                                <td>
                                    {{ number_format($child->isiIndikator->where('tahun', $tahun)->first()?->isi, 0, ',', '.') }}
                                </td>
                            @endif
                        @endforeach
                        @if (in_array($routePart, ['delapankeldata', 'rpjmd']))
                            <td>
                                <select class="form-control form-control-sm edit-sumber-data"
                                        data-url="{{ route('admin.' . $routePart . '.update_sumber_data', $child->id) }}"
                                        name="sumber_data"
                                        style="width: 200px;">
                                    <option selected
                                            value="">---</option>
                                    @foreach ($skpds as $id => $nama)
                                        <option @selected($id === $child->skpd_id)
                                                value="{{ $id }}">
                                            {{ $nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        @endif
                        <td>
                            @include('admin.isiUraian.partials.action', ['child' => $child])
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>
