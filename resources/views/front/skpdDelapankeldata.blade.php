@extends('layouts.appFront')
@section('title', ' 8 Kelompok Data SKPD')
@section('content')
  <div class="container">
    <div class="card">
      <div class="card-header bg-white card-header__lg">
        <h4 class="card-header__title">8 Kelompok Data SKPD</h4>
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
                        <ul>
                          @foreach ($child->childs as $child)
                            @foreach ($tabel8KelDataIds as $table)
                              @if ($table->id == $child->id)
                                <li @if (isset($tabel8KelData) && $tabel8KelData->id == $table->id) data-jstree='{ "selected" : true }' @endif>
                                  <a class="text-decoration-none"
                                    href="{{ route('delapankeldata.table', $child->id) }}">{{ $child->nama_menu }}</a>
                                </li>
                              @endif
                            @endforeach
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
