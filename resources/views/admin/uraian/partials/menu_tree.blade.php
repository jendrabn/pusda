<ul>
  <li data-jstree='{"opened":true}'>
    @if (request()->segment(3) === 'delapankeldata')
      8 Kelompok Data
    @elseif (request()->segment(3) === 'rpjmd')
      RPJMD
    @elseif (request()->segment(3) === 'indikator')
      Indikator
    @elseif (request()->segment(3) === 'bps')
      BPS
    @endif

    @foreach ($categories as $category)
      @if ($category->childs->count())
        <ul>
          @foreach ($category->childs as $child)
            <li>
              {{ $child->nama_menu }}
              @if ($child->childs->count())
                <ul>
                  @foreach ($child->childs as $child)
                    <li> {{ $child->nama_menu }}
                      <ul>
                        @if ($child->childs->count())
                          @foreach ($child->childs as $child)
                            <li @if ((isset($tabel8KelData) && $tabel8KelData->id === $child->id) || (isset($tabelRpjmd) && $tabelRpjmd->id === $child->id) || (isset($tabelIndikator) && $tabelIndikator->id === $child->id) || (isset($tabelBps) && $tabelBps->id === $child->id)) data-jstree='{ "selected" : true }' @endif>
                              @if (isset($skpd) && $skpd)
                                <a
                                  href="{{ route('admin.uraian.' . request()->segment(3) . '.index', $child->id) }}">{{ $child->nama_menu }}</a>
                              @else
                                <a
                                  href="{{ route('admin.uraian.' . request()->segment(3) . '.index', $child->id) }}">{{ $child->nama_menu }}</a>
                              @endif
                            </li>
                          @endforeach
                        @endif
                      </ul>
                    </li>
                  @endforeach
                </ul>
              @endif
            </li>
          @endforeach
        </ul>
      @endif
  </li>
  @endforeach
</ul>
