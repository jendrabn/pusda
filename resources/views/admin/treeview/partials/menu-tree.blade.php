<div class="card">
  <div class="card-header">
    <h4 class="text-uppercase">Tampilan Menu Tree View</h4>
  </div>
  <div class="card-body overflow-auto">
    <div id="treeview">
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
                    {{ $child->menu_name }}
                    @if ($child->childs->count())
                      <ul>
                        @foreach ($child->childs as $child)
                          <li> {{ $child->menu_name }}
                            <ul>
                              @if ($child->childs->count())
                                @foreach ($child->childs as $child)
                                  <li> {{ $child->menu_name }}</li>
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
</div>
