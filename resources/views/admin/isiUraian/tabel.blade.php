<div class="mb-3">
  <button class="btn btn-primary btn-flat mr-2"
    data-toggle="modal"
    data-target="#modalTahun"
    type="button">
    <i class="fas fa-calendar-alt mr-1"></i> Pengaturan Tahun
  </button>

  <a class="btn btn-success btn-flat"
    href="{{ route('exports.' . $crudRoutePart, $tabel->id) }}">
    <i class="fas fa-file-excel mr-1"></i>
    Excel
  </a>
</div>

<div class="table-responsive">
  <table class="table-bordered table-striped table-hover datatable datatable-isiuraian table table-sm">
    <thead>
      <tr>
        <th>
          &nbsp;
        </th>
        <th class="text-danger">
          Uraian
        </th>
        <th>
          Satuan
        </th>
        @if (in_array($crudRoutePart, ['delapankeldata', 'rpjmd']))
          <th>
            Ketersedian Data
          </th>
        @endif
        @foreach ($tahuns as $tahun)
          <th>
            {{ $tahun }}
          </th>
        @endforeach
        @if (in_array($crudRoutePart, ['delapankeldata', 'rpjmd']))
          <th>
            Sumber Data
          </th>
        @endif
        <th style="min-width: 110px;">
          &nbsp;
        </th>
      </tr>
    </thead>
    <tbody>
      @foreach ($uraians as $index => $uraian)
        <tr>
          <td class="text-center">
            @if (!$uraian->parent_id)
              {{ ++$index }}
            @endif
          </td>
          <td>
            <span class="text-danger">{{ $uraian->uraian }}</span>
          </td>
          <td>
            {{ $uraian->satuan }}
          </td>
          @if (in_array($crudRoutePart, ['delapankeldata', 'rpjmd']))
            <td>
              {{ $uraian->ketersediaan_data }}
            </td>
          @endif
          @foreach ($tahuns as $tahun)
            <td>
              &nbsp;
            </td>
          @endforeach
          @if (in_array($crudRoutePart, ['delapankeldata', 'rpjmd']))
            <td>
              &nbsp;
            </td>
          @endif
          <td>
            &nbsp;
          </td>
        </tr>
        @foreach ($uraian->childs as $child)
          <tr>
            <td>
              &nbsp;
            </td>
            <td>
              <span class="text-danger d-block"
                style="text-indent: 1.5rem;">{{ $child->uraian }}</span>
            </td>
            <td>{{ $child->satuan }}</td>
            @if (in_array($crudRoutePart, ['delapankeldata', 'rpjmd']))
              <td>
                {{ $child->label_ketersediaan_data }}
              </td>
            @endif
            @foreach ($tahuns as $tahun)
              @if ($crudRoutePart === 'delapankeldata')
                <td>
                  {{ $child->isi8KelData->where('tahun', $tahun)->first()->isi }}
                </td>
              @elseif ($crudRoutePart === 'rpjmd')
                <td>
                  {{ $child->isiRpjmd->where('tahun', $tahun)->first()->isi }}
                </td>
              @elseif ($crudRoutePart === 'bps')
                <td>
                  {{ $child->isiBps->where('tahun', $tahun)->first()->isi }}
                </td>
              @elseif ($crudRoutePart === 'indikator')
                <td>
                  {{ $child->isiIndikator->where('tahun', $tahun)->first()->isi }}
                </td>
              @endif
            @endforeach
            @if (in_array($crudRoutePart, ['delapankeldata', 'rpjmd']))
              <td>
                <select class="form-control sumber-data select2"
                  name="sumber_data"
                  data-url="@admin{{ route('admin.' . $crudRoutePart . '.update_sumber_data', $child->id) }}@endadmin @skpd{{ route('admin_skpd.' . $crudRoutePart . '.update_sumber_data', $child->id) }}@endskpd">
                  <option selected
                    disabled
                    hidden></option>
                  @foreach ($skpds as $id => $nama)
                    <option value="{{ $id }}"
                      {{ $id === $child->skpd_id ? 'selected' : '' }}>
                      {{ $nama }}
                    </option>
                  @endforeach
                </select>
              </td>
            @endif
            <td>
              <button class="btn btn-primary btn-xs btn-show-chart"
                data-url="{{ route('admin.' . $crudRoutePart . '.chart', $child->id) }}">
                Grafik
              </button>
              <a class="btn btn-xs btn-info"
                href="{{ route('admin.' . $crudRoutePart . '.edit', $child->id) }}">
                Edit
              </a>
              <form style="display: inline-block;"
                action="{{ route('admin.' . $crudRoutePart . '.destroy', $child->id) }}"
                method="POST"
                onsubmit="return confirm('Are You Sure?');">
                @method('DELETE')
                @csrf
                <input class="btn btn-xs btn-danger"
                  type="submit"
                  value="Delete">
              </form>
            </td>
          </tr>
        @endforeach
      @endforeach
    </tbody>
  </table>
</div>
