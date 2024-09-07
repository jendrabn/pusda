@extends('layouts.front')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header card-header__lg bg-white">
                <h4 class="card-header__title">{{ $title }}</h4>
            </div>
            <div class="card-body">
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
                                                               href="{{ route($routePart . '.tabel', $child->id) }}">{{ $child->nama_menu }}</a>
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

            </div>
        </div>
    </div>
@endsection
