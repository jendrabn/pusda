<ul>
  <li data-jstree='{"opened":true}'>RPJMD {{ isset($skpd) && $skpd ? $skpd->singkatan : '' }}
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
                            @if (isset($tabelRpjmdIds) && $tabelRpjmdIds)
                              @foreach ($tabelRpjmdIds as $item)
                                @if ($child->id === $item->tabel_rpjmd_id)
                                  <li @if (isset($tabelRpjmd) && $tabelRpjmd->id == $child->id) data-jstree='{ "selected" : true }' @endif>
                                    @if (isset($skpd) && $skpd)
                                      <a
                                        href="{{ route('admin.rpjmd.input', [$child->id, $skpd->id]) }}">{{ $child->nama_menu }}</a>
                                    @else
                                      <a
                                        href="{{ route('admin.rpjmd.input', [$child->id]) }}">{{ $child->nama_menu }}</a>
                                    @endif
                                  </li>
                                @endif
                              @endforeach
                            @else
                              <li @if (isset($tabelRpjmd) && $tabelRpjmd->id === $child->id) data-jstree='{ "selected" : true }' @endif>
                                <a href="{{ route('admin.rpjmd.input', $child->id) }}">{{ $child->nama_menu }}</a>
                              </li>
                            @endif
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
