@extends('layouts.admin')

@section('content')
  <div class="row">
    @foreach ($category->skpd as $skpd)
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body d-flex flex-column justify-content-center align-items-center">
            <div class="mb-2 text-dark"><i class="fas fa-tv" style="font-size: 2.5rem"></i></div>
            <p class="mb-0"><a class="stretched-link"
                href="{{ route('admin.' . $crudRoutePart . '.index', ['skpd' => $skpd->id]) }}">{{ $skpd->singkatan }}</a>
            </p>
          </div>
        </div>
      </div>
    @endforeach
  </div>
@endsection
