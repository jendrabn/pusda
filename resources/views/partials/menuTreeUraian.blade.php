<ul>
  <li data-jstree='{"opened":true}'>
    @if ($crudRoutePart === 'delapankeldata')
      8 Kelompok Data
    @elseif ($crudRoutePart === 'rpjmd')
      RPJMD
    @elseif ($crudRoutePart === 'indikator')
      Indikator
    @elseif ($crudRoutePart === 'bps')
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
                            <li @if (isset($table) && $table->id === $child->id) data-jstree='{ "selected" : true }' @endif>
                              <a
                                href="{{ route('admin.uraian.' . $crudRoutePart . '.index', $child->id) }}">{{ $child->nama_menu }}</a>
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
