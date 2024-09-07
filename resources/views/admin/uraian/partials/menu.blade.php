@if ($child->childs->count())
    <ul>
        @foreach ($child->childs as $child)
            <li> {{ $child->nama_menu }}
                @if ($level >= 2)
                    <ul>
                        @if ($child->childs->count())
                            @foreach ($child->childs as $child)
                                <li @if (isset($tabel) && $tabel->id === $child->id) data-jstree='{ "selected" : true }' @endif>
                                    <a
                                       href="{{ route('admin.uraian.' . $routePart . '.index', $child->id) }}">{{ $child->nama_menu }}</a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                @else
                    @include('admin.uraian.partials.menu', ['child' => $child, 'level' => $level + 1])
                @endif
            </li>
        @endforeach
    </ul>
@endif
