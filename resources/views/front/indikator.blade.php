@extends('front.layouts.app')
@section('title', 'Indikator')
@section('content')
  <div class="container">
    <div class="card">
      <div class="card-header bg-white card-header__lg">
        <h4 class="card-header__title">Indikator</h4>
      </div>
      <div class="card-body">
        @include('front.partials.menu_tree', ['categories' => $categories, 'routePart' => 'indikator'])
      </div>
    </div>
  </div>
@endsection
