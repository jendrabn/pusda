@extends('layouts.appFront')
@section('title', ' 8 Kelompok Data')
@section('content')
  <div class="container">
    <div class="card">
      <div class="card-header bg-white card-header__lg">
        <h4 class="card-header__title">8 Kelompok Data</h4>
      </div>
      <div class="card-body">
        @include('front.partials.menuTree', [
            'categories' => $categories,
            'routePart' => 'delapankeldata',
        ])
      </div>
    </div>
  </div>
@endsection
