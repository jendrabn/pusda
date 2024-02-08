<div class="card">
  <div class="card-header">
    <h3 class="card-title">
      Menu Tree View {{ $title }}</h3>
  </div>
  <div class="card-body jstree overflow-auto">
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
                                        @role(App\Models\User::ROLE_ADMIN)
                                          @if (isset($skpd) && $skpd)
                                            <a
                                              href="{{ route('admin.' . $crudRoutePart . '.input', [$child->id, 'skpd' => $skpd->id]) }}">{{ $child->nama_menu }}</a>
                                          @else
                                            <a
                                              href="{{ route('admin.' . $crudRoutePart . '.input', [$child->id]) }}">{{ $child->nama_menu }}</a>
                                          @endif
                                        @endrole
                                        @role(App\Models\User::ROLE_SKPD)
                                          <a
                                            href="{{ route('admin_skpd.' . $crudRoutePart . '.input', $child->id) }}">{{ $child->nama_menu }}</a>
                                        @endrole
                                      </li>
                                    @endif
                                  @endforeach
                                @else
                                  <li @if (isset($tabel) && $tabel->id === $child->id) data-jstree='{ "selected" : true }' @endif>
                                    @role(App\Models\User::ROLE_ADMIN)
                                      <a
                                        href="{{ route('admin.' . $crudRoutePart . '.input', $child->id) }}">{{ $child->nama_menu }}</a>
                                    @endrole
                                    @role(App\Models\User::ROLE_SKPD)
                                      <a
                                        href="{{ route('admin_skpd.' . $crudRoutePart . '.input', $child->id) }}">{{ $child->nama_menu }}</a>
                                    @endrole
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
