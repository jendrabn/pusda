<ol>
  @foreach ($categories as $category)
    <li>
      {{ $category->nama_menu }}
      @if ($category->childs->count())
        <ol style="list-style-type: lower-latin">
          @foreach ($category->childs as $child)
            <li>
              {{ $child->nama_menu }}
              @if ($child->childs->count())
                <ul style="list-style-type: disc">
                  @foreach ($child->childs as $child)
                    <li>
                      <a class="text-decoration-none"
                        href="{{ route('guest.bps.table', $child->id) }}">{{ $child->nama_menu }}</a>

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
