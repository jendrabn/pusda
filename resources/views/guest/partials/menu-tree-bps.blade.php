<ol>
  @foreach ($categories as $category)
    <li>
      {{ $category->menu_name }}
      @if ($category->childs->count())
        <ol style="list-style-type: lower-latin">
          @foreach ($category->childs as $child)
            <li>
              {{ $child->menu_name }}
              @if ($child->childs->count())
                <ul style="list-style-type: disc">
                  @foreach ($child->childs as $child)
                    <li>
                      <a class="text-decoration-none"
                        href="{{ route('guest.bps.table', $child->id) }}">{{ $child->menu_name }}</a>

                      <div>
                        <canvas class="isi-uraian-chart" width="13" height="5" data-id="{{ $child->id }}"></canvas>
                      </div>
                    </li>
                  @endforeach
                </ul>
              @endif
            </li>
          @endforeach
        </ol>
      @endif
    </li>
  @endforeach
</ol>
