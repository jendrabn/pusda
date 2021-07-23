@extends('guest.layouts.app')

@section('title')
  8 Kelompok Data SKPD
@endsection

@section('content')
  <div class="container">
    <div class="card">
      <div class="card-header bg-white card-header__lg">
        <h4 class="card-header__title">8 Kelompok Data SKPD</h4>
      </div>
      <div class="card-body">
        <ol>
          @foreach ($skpd as $skpd)
            <li><a class="text-decoration-none"
                href="{{ route('guest.delapankeldata.skpd', $skpd->id) }}">{{ $skpd->nama }}</a>
            </li>
          @endforeach
        </ol>
      </div>
    </div>
  </div>
@endsection
