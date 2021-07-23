  <ul>
    <li data-jstree='{"opened":true}'>Indikator
      @foreach ($categories as $category)
        @if ($category->childs->count())
          <ul>
            @foreach ($category->childs as $child)
              <li>
                {{ $child->menu_name }}
                @if ($child->childs->count())
                  <ul>
                    @foreach ($child->childs as $child)
                      <li> {{ $child->menu_name }}
                        <ul>
                          @if ($child->childs->count())
                            @foreach ($child->childs as $child)
                              <li @if (isset($tabelIndikator) && $tabelIndikator->id == $child->id) data-jstree='{ "selected" : true }' @endif>
                                <a
                                  href="{{ route('admin.indikator.index', $child->id) }}">{{ $child->menu_name }}</a>
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
