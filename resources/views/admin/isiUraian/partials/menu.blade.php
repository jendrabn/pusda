@if ($child->childs->count())
    <ul>
        @foreach ($child->childs as $child)
            <li> {{ $child->nama_menu }}
                @if ($level >= 2)
                    <ul>
                        @if ($child->childs->count())
                            @foreach ($child->childs as $child)
                                @if (isset($tabel_ids) && $tabel_ids)
                                    @foreach ($tabel_ids as $item)
                                        @if ($child->id === $item->tabel_id)
                                            <li
                                                @if (isset($tabel) && $tabel->id == $child->id) data-jstree='{ "selected" : true }' @endif>
                                                @role(App\Models\User::ROLE_ADMIN)
                                                    @if (isset($skpd) && $skpd)
                                                        <a
                                                           href="{{ route('admin.' . $routePart . '.input', [$child->id, 'skpd' => $skpd->id]) }}">{{ $child->nama_menu }}</a>
                                                    @else
                                                        <a
                                                           href="{{ route('admin.' . $routePart . '.input', [$child->id]) }}">{{ $child->nama_menu }}</a>
                                                    @endif
                                                @endrole
                                                @role(App\Models\User::ROLE_SKPD)
                                                    <a
                                                       href="{{ route('admin.' . $routePart . '.input', $child->id) }}">{{ $child->nama_menu }}</a>
                                                @endrole
                                            </li>
                                        @endif
                                    @endforeach
                                @else
                                    <li @if (isset($tabel) && $tabel->id === $child->id) data-jstree='{ "selected" : true }' @endif>
                                        @role(App\Models\User::ROLE_ADMIN)
                                            <a
                                               href="{{ route('admin.' . $routePart . '.input', $child->id) }}">{{ $child->nama_menu }}</a>
                                        @endrole
                                        @role(App\Models\User::ROLE_SKPD)
                                            <a
                                               href="{{ route('admin.' . $routePart . '.input', $child->id) }}">{{ $child->nama_menu }}</a>
                                        @endrole
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    </ul>
                @else
                    @include('admin.isiUraian.partials.menu', ['child' => $child, 'level' => $level + 1])
                @endif
            </li>
        @endforeach
    </ul>
@endif
