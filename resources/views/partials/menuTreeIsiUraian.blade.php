<div class="card">
  <div class="card-header">Menu Tree View {{ $title }}</div>
  <div class="card-body menu__treeview overflow-auto">
    <ul>
        <li data-jstree='{"opened":true}'>{{ $title }} {{ isset($skpd) && $skpd ? $skpd->singkatan : '' }}
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
                                  @if (isset($tabelIds) && $tabelIds)
                                    @foreach ($tabelIds as $item)
                                      @if ($child->id === $item->tabel_id)
                                        <li @if (isset($tabel) && $tabel->id == $child->id) data-jstree='{ "selected" : true }' @endif>
                                          @if (isset($skpd) && $skpd)
                                            <a
                                              href="{{ route('admin.' . $crudRoutePart . '.input', [$child->id, 'skpd' => $skpd->id]) }}">{{ $child->nama_menu }}</a>
                                          @else
                                            <a
                                              href="{{ route('admin.' . $crudRoutePart . '.input', [$child->id]) }}">{{ $child->nama_menu }}</a>
                                          @endif
                                        </li>
                                      @endif
                                    @endforeach
                                  @else
                                    <li @if (isset($tabel) && $tabel->id === $child->id) data-jstree='{ "selected" : true }' @endif>
                                      <a
                                        href="{{ route('admin.' . $crudRoutePart . '.input', $child->id) }}">{{ $child->nama_menu }}</a>
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

  </div>
</div>

